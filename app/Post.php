<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// Import một trait tên SoftDeletes. Trait (có thể hình dung như class) là
// một nhóm các method có thể được import vào để sử dụng method của nó trong 
// class khác.
// Trait này cung cấp các method hỗ trợ soft delete (cho vào thùng rác) cho model.
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
	// Import trait tên SoftDeletes để sử dụng phương thức của nó, để tạo tính năng 
	// soft delete.
	use SoftDeletes;

	// Gán giá trị cho thuộc tính kiểu mảng fillable của Laravel để chỉ định
	// các field được phép massive-assign bởi phương thức create() (phương thức
	// có chức năng tạo thể hiện model và lưu record tương ứng vào DB) của Laravel.
	// Nếu không gán giá trị thuộc tính này, sẽ xuất hiện lỗi bảo mật massive-assign
	// khi dùng phương thức create() của Eloquent ORM trong Laravel.
	protected $fillable = [
		'title', 'content', 'category_id', 'featured', 'slug'
	];


	// Đây là phương thức Accsessor để biến đổi dữ liệu sau khi được lấy ra từ model
	// nhằm mục đích định dạng cho việc hiển thị trên view.
	// Tên phương thức được đặt theo qui tắc của Laravel: get + tên field + Attribute
	// Tên được tổ hợp lại theo luật Camel Case.
	// Phương thức được tự động kích hoạt khi dữ liệu được lấy ra từ model.
	// Đối số của phương thức là giá trị của field cần chuyển đổi.
	// Cụ thể: accessor này làm biến đổi thuộc tính featured (đường dẫn ảnh đặc trưng 
	// của bài post) thành đường dẫn đầy đủ trong ứng dụng.
	public function getFeaturedAttribute($featured) {
		// Hàm asset của Laravel cho đường dẫn đầy đủ trong ứng dụng của đường dẫn 
		// lưu trong thuộc tính featured.
		return asset($featured);
	}


	// Tạo thuộc tính này để báo cho Eloquent ORM model biết có thêm field kiểu thời điểm
	// (timestamp) tên deleted_at để tạo tính năng soft delete.
	protected $dates = ['deleted_at'];

    // Phương thức này để thiết lập mối quan hệ cho table Posts và Categories.
    // Một Post chỉ thuộc về một Category. Đặt tên phương thức để thể 
    // hiện điều này, tên phương thức sẽ ở dạng số ít.
    public function category(){
    	// Thiết lập mối quan hệ với table Categories.
    	// belongsTo() là phương thức xây dựng sẵn của Laravel. Từ khóa this chỉ class
    	// hiện hành (Category).
    	return $this->belongsTo('App\Category');
    }


    // Thiết lập mối quan hệ: Một post có nhiều tag
    public function tags() {
    	return $this->belongsToMany('App\Tag');
    }
}
