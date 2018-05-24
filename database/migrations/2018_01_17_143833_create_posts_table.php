<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug');  // Field này được dùng để xác định bài post, để hiển thị 
            // trên thanh địa chỉ của trình duyệt khi user truy cập bài post
            $table->text('content');
            // Đặt tên cho field khóa ngoại theo qui ước tên model_id. Laravel
            // sử dụng qui ước này để tạo mối quan hệ giữa các table.
            $table->integer('category_id');
            $table->string('featured');

            // Phương thức softDeletes() để tạo field tên deleted_at trong table,
            // tạo tính năng soft delete của Laravel. Field này sẽ tự động có giá trị 
            // null khi một thể hiện model mới được thêm. Khi thể hiện model bị xóa,
            // mẩu tin tương ứng không bị xóa mà field deleted_at sẽ có giá trị là
            // thời điểm xóa. Khi truy vấn, các mẩu tin có giá trị khác null tại field
            // này sẽ bị bỏ qua.
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
