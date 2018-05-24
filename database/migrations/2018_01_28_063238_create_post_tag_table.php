<?php

// Đây là migration để tạo một pivot table (table trung gian cho mối quan hệ n-n
// giữa bảng Posts và bảng Tags)


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Tạo cấu trúc table.

        // Đối số 1: Tên table
        // Đối số 2: Một closure để tạo cấu trúc table
        Schema::create('post_tag', function(Blueprint $table){
            $table->increments('id');   // Tạo field tên id có kiển int tự động
            $table->integer('post_id'); // Tạo field tên post_id kiểu int
            $table->integer('tag_id'); // Tạo field tên tag_id kiểu int
            $table->timestamps();       // Tạo các field timestamp
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Dùng cho trường hợp rollback migration
        Schema::drop('post_tag');
    }
}
