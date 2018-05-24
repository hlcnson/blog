<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //Cho phép massive-assign đối với field tên tag
    protected $fillable = ['tag'];

	// Thiết lập mối quan hệ: Một tag thuộc về nhiều post
    public function posts() {
    	return $this->belongsToMany('App\Post');
    }
}
