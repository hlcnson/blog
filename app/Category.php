<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Phương thức này để thiết lập mối quan hệ 1-nhiều cho table Categories và Posts
    // Một Category có thể có nhiều post. Đặt tên phương thức để thể 
    // hiện điều này, tên phương thức sẽ ở dạng số nhiều.
    public function posts(){
    	// Thiết lập mối quan hệ 1-n với table Pots.
    	// hasMany() là phương thức xây dựng sẵn của Laravel. Từ khóa this chỉ class
    	// hiện hành (Category).
    	return $this->hasMany('App\Post');
    }
}
