<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Profile extends Model
{
    //Thiết lập mối quan hệ 1-1 theo chiều ngược lại với table Users
    public function user(){
    	return $this->belongsTo('App/User');
    }


    // Gán giá trị cho thuộc tính kiểu mảng fillable của Laravel để chỉ định
	// các field được phép massive-assign bởi phương thức create() (phương thức
	// có chức năng tạo thể hiện model và lưu record tương ứng vào DB) của Laravel.
	// Nếu không gán giá trị thuộc tính này, sẽ xuất hiện lỗi bảo mật massive-assign
	// khi dùng phương thức create() của Eloquent ORM trong Laravel.
	protected $fillable = [
		'user_id', 'avatar', 'youtube', 'facebook', 'about'
	];
}

