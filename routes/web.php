<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('test', function(){
	dd(App\Category::find(1)->posts());
});

Route::get('/', function () {
    return view('welcome');
});

// Phương thức routes() sẽ nạp và đăng một loạt các route trong ứng dụng tại đây
// bao gồm cả chức năng authentication
Auth::routes();




// Tạo một route group để xác định đối tượng có thể truy cập route.
// Phương thức group của class Route có hai đối số.
// Đối số 1: Một array với: 
// 			Chỉ mục prefix: để chỉ định prefix cho các route,
// 			các route trong nhóm sẽ tự động có thêm prefix được chỉ định 
// 			trong array (admin).
// 			Chỉ mục middleware: Định nghĩa một middleware, hoạt động như một filter
// 			để lọc các yêu cầu đến các route của ứng dụng nhằm xác định quyền truy cập
// 			của user. Middleware tên là auth để bảo vệ route khỏi những user chưa được
// 			chứng thực (authenticate)
// Ví dụ: /admin/post/create, /admin/post/store
// Đối số 2: Là một closure chứa các route, các route nằm ở đây sẽ thuộc về group.
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function(){

	// Phương thức name() là một trong các cách Laravel hỗ trợ để đặt tên cho route.
	// Đây là một cú pháp để xác định phương thức của controller cho một route.
	// Cũng có thể sử dụng mảng cấu hình route với chỉ mục as để định nghĩa tên route.
	// Tên của route này là home
	Route::get('/home', 'HomeController@index')->name('home');


	// Route dạng GET: Để hiển thị form tạo post mới.
	// Tên tham chiếu của route là post.create.
	// Tên Controller có trách nhiệm xử lý: PostsController
	// Tên phương thức xử lý: create
	Route::get('post/create', [
		'uses' => 'PostsController@create',
		'as' => 'post.create'
	]);

	// Route dạng POST: Để lưu post mới vào DB.
	// Tên tham chiếu của route là post.store.
	// Tên Controller có trách nhiệm xử lý: PostsController
	// Tên phương thức xử lý: store
	Route::post('post/store', [
		'uses' => 'PostsController@store',
		'as' => 'post.store'
	]);


	// Route dạng GET: Để hiển thị các bài post.
	// Tên tham chiếu của route là posts.
	// Tên Controller có trách nhiệm xử lý: PostsController
	// Tên phương thức xử lý: index
	Route::get('posts', [
		'uses' => 'PostsController@index',
		'as' => 'posts'
	]);


	// Route dạng GET: Để xóa tạm các bài post.
	// Tên tham chiếu của route là post/delete.
	// Tên Controller có trách nhiệm xử lý: PostsController
	// Tên phương thức xử lý: destroy
	// Route có tham số tên id, cần được truyền giá trị khi route được kích hoạt.
	// Giá trị tham số sau đó được truyền vào cho action của controller
	Route::get('post/delete/{id}', [
		'uses' => 'PostsController@destroy',
		'as' => 'post.delete'
	]);


	// Route dạng GET: Để hiển thị các bài post đã bị xóa tạm.
	// Tên tham chiếu của route là posts.trashed.
	// Tên Controller có trách nhiệm xử lý: PostsController
	// Tên phương thức xử lý: trashed
	Route::get('posts/trashed', [
		'uses' => 'PostsController@trashed',
		'as' => 'posts.trashed'
	]);


	// Route dạng GET: Để xóa khỏi DB bài post đã bị xóa tạm.
	// Tên tham chiếu của route là post.kill.
	// Tên Controller có trách nhiệm xử lý: PostsController
	// Tên phương thức xử lý: kill
	// Route có tham số tên id, cần được truyền giá trị khi route được kích hoạt.
	// Giá trị tham số sau đó được truyền vào cho action của controller
	Route::get('posts/kill/{id}', [
		'uses' => 'PostsController@kill',
		'as' => 'post.kill'
	]);


	// Route dạng GET: Để phục hồi bài post đã bị xóa tạm.
	// Tên tham chiếu của route là post.restore.
	// Tên Controller có trách nhiệm xử lý: PostsController
	// Tên phương thức xử lý: restore
	// Route có tham số tên id, cần được truyền giá trị khi route được kích hoạt.
	// Giá trị tham số sau đó được truyền vào cho action của controller
	Route::get('posts/restore/{id}', [
		'uses' => 'PostsController@restore',
		'as' => 'post.restore'
	]);


	// Route dạng GET: Để phục hiển thị form edit bài post.
	// Tên tham chiếu của route là post.edit.
	// Tên Controller có trách nhiệm xử lý: PostsController
	// Tên phương thức xử lý: edit
	// Route có tham số tên id, cần được truyền giá trị khi route được kích hoạt.
	// Giá trị tham số sau đó được truyền vào cho action của controller
	Route::get('posts/edit/{id}', [
		'uses' => 'PostsController@edit',
		'as' => 'post.edit'
	]);


	// Route dạng POST: Để lưu dữ liệu bài post.
	// Tên tham chiếu của route là post.update.
	// Tên Controller có trách nhiệm xử lý: PostsController
	// Tên phương thức xử lý: update
	// Route có tham số tên id, cần được truyền giá trị khi route được kích hoạt.
	// Giá trị tham số sau đó được truyền vào cho action của controller
	Route::post('posts/update/{id}', [
		'uses' => 'PostsController@update',
		'as' => 'post.update'
	]);


	// Route dạng GET: Để hiển thị form tạo category.
	// Tên tham chiếu của route là category.create.
	// Tên Controller có trách nhiệm xử lý: CategoriesController
	// Tên phương thức xử lý: create
	Route::get('category/create', [
		'uses' => 'CategoriesController@create',
		'as' => 'category.create'
	]);


	// Route dạng POST: Để lưu category mới vào DB.
	// Tên tham chiếu của route là category.store.
	// Tên Controller có trách nhiệm xử lý: CategoriesController
	// Tên phương thức xử lý: store
	Route::post('category/store', [
		'uses' => 'CategoriesController@store',
		'as' => 'category.store'
	]);

	// Route dạng GET: Để hiển thị danh sách category.
	// Tên tham chiếu của route là categories.
	// Tên Controller có trách nhiệm xử lý: CategoriesController
	// Tên phương thức xử lý: index
	Route::get('categories', [
		'uses' => 'CategoriesController@index',
		'as' => 'categories'
	]);


	// Route dạng GET: Để hiển form edit category.
	// Tên tham chiếu của route là category.edit.
	// Tên Controller có trách nhiệm xử lý: CategoriesController
	// Tên phương thức xử lý: edit
	// Route có tham số tên id, cần được truyền giá trị khi route được kích hoạt.
	// Giá trị tham số sau đó được truyền vào cho action của controller
	Route::get('category/edit/{id}', [
		'uses' => 'CategoriesController@edit',
		'as' => 'category.edit'
	]);


	// Route dạng GET: Để xóa category.
	// Tên tham chiếu của route là category.delete.
	// Tên Controller có trách nhiệm xử lý: CategoriesController
	// Tên phương thức xử lý: destroy
	// Route có tham số tên id, cần được truyền giá trị khi route được kích hoạt.
	// Giá trị tham số sau đó được truyền vào cho action của controller
	Route::get('category/delete/{id}', [
		'uses' => 'CategoriesController@destroy',
		'as' => 'category.delete'
	]);


	// Route dạng POST: Để lưu dữ liệu cập nhật category vào DB.
	// Tên tham chiếu của route là category.update.
	// Tên Controller có trách nhiệm xử lý: CategoriesController
	// Tên phương thức xử lý: update
	// Route có tham số tên id, cần được truyền giá trị khi route được kích hoạt.
	// Giá trị tham số sau đó được truyền vào cho action của controller
	Route::post('category/update/{id}', [
		'uses' => 'CategoriesController@update',
		'as' => 'category.update'
	]);


	// Các route cho tính năng CRUD trên model Tag

	Route::get('tags', [
		'uses' => 'TagsController@index',
		'as' => 'tags'
	]);

	Route::get('tag/edit/{id}', [
		'uses' => 'TagsController@edit',
		'as' => 'tag.edit'
	]);

	Route::post('tag/update/{id}', [
		'uses' => 'TagsController@update',
		'as' => 'tag.update'
	]);

	Route::get('tag/delete/{id}', [
		'uses' => 'TagsController@destroy',
		'as' => 'tag.delete'
	]);

	Route::get('tag/create', [
		'uses' => 'TagsController@create',
		'as' => 'tag.create'
	]);

	Route::post('tag/store', [
		'uses' => 'TagsController@store',
		'as' => 'tag.store'
	]);

	// Các route để quản lý user.

	// Hiển thị danh mục users
	Route::get('/users', [
		'uses' => 'UsersController@index',
		'as' => 'users'
	]);

	// Hiển thị form user
	Route::get('/user/create', [
		'uses' => 'UsersController@create',
		'as' => 'user.create'
	]);

	// Lưu user vào DB
	Route::post('/user/store', [
		'uses' => 'UsersController@store',
		'as' => 'user.store'
	]);

	// Chuyển user bình thường thành admin, route cần tham số là id của user
	Route::get('/user/admin/{id}', [
		'uses' => 'UsersController@admin',
		'as' => 'user.make.admin'
	]);

	// Chuyển admin thành user bình thường, route cần tham số là id của user
	Route::get('/user/not-admin/{id}', [
		'uses' => 'UsersController@not_admin',
		'as' => 'user.make.not.admin'
	]);

	// Hiển thị view để cập nhật profile của user
	Route::get('/user/profile', [
		'uses' => 'ProfilesController@index',
		'as' => 'user.profile'
	]);

	// Lưu profile cập nhật của user vào DB
	Route::post('/user/profile/update', [
		'uses' => 'ProfilesController@update',
		'as' => 'user.profile.update'
	]);

	// Xóa tài khoản của user, route cần tham số là id của user cần xóa
	Route::get('/user/delete/{id}', [
		'uses' => 'UsersController@destroy',
		'as' => 'user.delete'
	]);

});


