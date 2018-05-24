<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use File;

// Sử dụng model Category, Post
use App\Category;
use App\Post;
use App\Tag;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Phương thức để hiển thị view liệt kê các bài post


        // Phương thức all() để lấy mọi record (có field deleted_at mang giá trị null)
        // trong table Posts
        $posts = Post::all();

        // Trả về view nằm trong thư mục admin\posts\index.blade.php.
        // Đồng thời truyền biến (tên posts_view) chứa danh sách các mẩu
        // tin post cho view để hiển thị.
        return view('admin.posts.index')->with('posts_view', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Phương thức để hiển thị form tạo post (bài viết) mới

        // Kiểm tra xem có mẩu tin category nào trong DB hay không.
        // Phương thức all() để lấy mọi record trong table Categories
        $categories = Category::all();
        if ($categories->count() == 0) {
            // Chưa có mẩu tin nào
            // --> ghi thông báo vào Session với khóa là info và điều hướng về trang trước
            Session::flash('info', 'You must have some categories before attemting to create a post.');
            return redirect()->back();
        }


        // Trả về view nằm trong thư mục admin\posts\create.blade.php.
        // Đồng thời truyền 2 biến:
        // categories_view chứa danh sách các mẩu tin category cho view để hiển
        // thị và cho người dùng chọn category khi thêm mới một post.
        // tags_view chứa các mẩu tin tag (thẻ bài viết)
        return view('admin.posts.create')->with('categories_view', $categories)
                                        ->with('tags_view', Tag::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Phương thức này lưu trữ bài viết vào Database

        // Dành cho mục đích debug
        // dd($request->all());

        // Phương thức validate (được kế thừa từ các base class) có chức năng
        // kiểm tra dữ liệu.
        // Tham số thứ nhất: Dữ liệu để kiểm tra, trong đôi tượng $request
        // Tham số thứ 2: Mảng các rule để kiểm tra data, dành cho các field trong
        // đối tượng request do trình duyệt post về. Trường hợp này, $request được
        // post về từ form để thêm bài viết (post) mới, có các field tên: title,
        // featured, category_id, content (xem migration của bảng Posts).
        // Nếu một field có nhiều hơn một rule, ngăn cách chúng bằng dấu | (pipe).
        // Ý nghĩa rule:
        //      required: Bắt buộc có
        //      max:255    Tối đa 255 ký tự
        //      image       Phải là hình ảnh
        //
        $this->validate($request, [
            'title' => 'required|max:255',
            'featured' => 'required|image',
            'content' => 'required',
            'category_id' => 'required',
            'tags' => 'required'
        ]);

        // Lấy image từ đối tượng $request
        $featured = $request->featured;

        // Tạo tên mới cho file image bằng cách ghép thời điểm hiện tại với tên gốc của file
        $featured_new_name = time() . $featured->getClientOriginalName();

        // Lưu trữ file ảnh của bài post vào thư mục uploads/posts với tên mới tạo ở trên
        $featured->move('uploads/posts', $featured_new_name);

        // Tạo đối tượng post mới
        // Đây là một cách
        // $post = new Post;
        // Đây là cách nhanh hơn. Phương thức create kế thừa từ class Model (Eloquent Model).
        // Phương thức này nhận một đối số là một mảng với các chỉ mục trùng khớp với cấu
        // trúc table trong DB (xem phần migration của model).
        // Riêng phần file ảnh đặc trưng của bài post, chỉ lưu đường dẫn file vào DB,
        // file ảnh đã được upload vào thư mục asset/uploads/posts.
        // Phương thức này tạo đối tượng model mới và insert nó vào database.
        // Hàm str_slug để chuyển một chuỗi thường (tiêu đề của post) thành một slug
        // làm id cho bài post ở chế độ truy cập của user không phải admin
        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'featured' => 'uploads/posts/' . $featured_new_name,
            'category_id' => $request->category_id,
            'slug' => str_slug($request->title)
        ]);

        // Phương thức create() ở trên có thể tạo ra lỗi bảo mật Massive-assignment (lỗi
        // gán quá nhiều thuộc tính model cùng lúc). Gán giá trị cho thuộc tính fillable của
        // model để chỉ định field được phép mass-assign hoặc thuộc tính guarded để chỉ
        // định field không được mass-assign.


        // Truy cập tags relationship, gọi phương thức attach() để truy cập mối quan hệ với
        // bảng tags. Phương thức attach có thể được truy cập sau khi đã thiết lập được
        // pivot table cho mối quan hệ.
        // Phương thức attach nhận đối số là mảng id của các tag có quan hệ với bài post
        // vừa tạo bởi phương thức create ở trên và lưu chúng vào pivot table của mối quan hệ.
        // tags là mảng chứa các id của các tag được chọn trên form được post về trong
        // đối tượng request.
        $post->tags()->attach($request->tags);

        // Ghi thông điệp báo thêm bài post thành công vào Session của ứng dụng với khóa
        // là success.
        Session::flash('success', 'Post created successfully');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Phương thức hiển thị view để cập nhật bài post

        // Tìm mẩu tin post có id tương ứng. Trong table Posts có cột id là khóa chính.
        // Phương thức find tìm record theo giá trị cột id.
        $post = Post::find($id);

        // Chuyển mẩu tin post tìm được cho view để edit.
        // Trả về view nằm trong thư mục admin\posts\edit.blade.php.
        // Đồng thời truyền biến (tên post_view) là mẩu tin post cho view với tên post_view,
        // và biến chứa các mẩu tin category để hiển thị trên form, biến chứa các mẩu tin tag
        return view('admin\posts\edit')->with('post_view', $post)
                                        ->with('categories_view', Category::all())
                                        ->with('tags_view', Tag::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Phương thức để cập nhật dữ liệu mới của bài post vào DB

        // Phương thức validate (được kế thừa từ các base class) có chức năng
        // kiểm tra dữ liệu.
        // Tham số thứ nhất: Dữ liệu để kiểm tra, trong đôi tượng $request
        // Tham số thứ 2: Mảng các rule để kiểm tra data, dành cho các field trong
        // đối tượng request do trình duyệt post về. Trường hợp này, $request được
        // post về từ form edit bài post (trong view update.blade.php).
        // Nếu một field có nhiều hơn một rule, ngăn cách chúng bằng dấu | (pipe).
        // Ý nghĩa rule:
        //      required: Bắt buộc có
        //      max:255    Tối đa 255 ký tự
        //      image       Phải là hình ảnh
        // Không kiểm tra file ảnh đặc trưng (featured) vì khi cập nhật post,
        // người dùng có thể không upload ảnh mới cho bài post.
        $this->validate($request, [
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required'
        ]);

        // Xác định record của bài post cần update theo id
        $post = Post::find($id);

        // Phương thức hasFile() kiểm tra xem user có upload file ảnh hay không.
        // featured là name của điều khiển upload file trên view.
        if ($request->hasFile('featured')) {
            // Có file được upload lên => lưu file

            // Lấy image từ đối tượng $request
            $featured = $request->featured;

            // Tạo tên mới cho file image bằng cách ghép thời điểm hiện tại với tên gốc của file
            $featured_new_name = time() . $featured->getClientOriginalName();

            // Lưu trữ file ảnh của bài post vào thư mục uploads/posts với tên mới tạo ở trên
            $featured->move('uploads/posts', $featured_new_name);

            // Kiểm tra xem file ảnh cũ của bài post có tồn tại hay không
            // Helper-function tên public_path của Laravel trả về đường dẫn đầy đủ đến
            // thư mục public của dự án, file ảnh đặt trong thư mục public.
            // Helper-function tên exists kiểm tra sự tồn tại của file.
            // Phương thức getOriginal() giúp lấy giá trị thuộc tính của model
            // mà không thông qua Accessor (làm biến đổi dữ liệu bằng helper-function
            // tên asset, xem Post.php). Nếu qua Accessor đường dẫn sẽ bị sai.
            if (File::exists(public_path($post->getOriginal('featured')))) {
                // File ảnh cũ tồn tại
                // Xóa file
                File::delete(public_path($post->getOriginal('featured')));
            }
            // dd(public_path($post->getOriginal('featured')));

            // Cập nhật lại tên file ảnh trong DB
            $post->featured = 'uploads/posts/' . $featured_new_name;
        }

        // Cập nhật dữ liệu của record bài post
        $post->title = $request->title;
        $post->content = $request->content;
        $post->category_id = $request->category_id;

        // Lưu vào DB
        $post->save();

        // Cập nhật pivot table (bảng trung gian trong mối quan hệ n-n giữa bảng post và tag)
        // tên post_tag.
        // Phương thức tags() trả về relationship giữa bảng post và tag.
        // Phương thức sync() nhận đối số là mảng chứa các id của các tag. Mảng tags trong đối tượng
        // $request được post về từ form trong view, phương thức này sẽ xóa bỏ các mẩu tin thể hiện
        // mối quan hệ post-tag hiện có và kích hoạt phương thức attach để tạo lại mối quan hệ post-tag
        // dựa trên các id trong mảng tags.
        $post->tags()->sync($request->tags);

        // Ghi thông điệp cập nhật bài post thành công vào khóa succes của Session
        Session::flash('success', 'The post was updated successfully.');

        // Điều hướng về route có tên tham chiếu là posts (danh mục bài post)
        return redirect()->route('posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Action để xóa tạm bài post có id được truyền qua tham số của action

        // Tìm mẩu tin post có id tương ứng. Trong table Posts có cột id là khóa chính.
        // Phương thức find tìm record theo giá trị cột id.
        $post = Post::find($id);

        // Xóa tạm mẩu tin
        $post->delete();

        // Ghi thông báo vào khóa success của sesstion
        Session::flash('success', 'The post was just deleted.');

        // Điều hướng về trang trước
        return redirect()->back();
    }


    // Action để hiển thị các bài post bị xóa tạm (field deleted_at có giá trị
    // là thời điểm bị xóa)
    public function trashed() {
        // Phương thức onlyTrashed của ORM model hoạt động như một query chỉ truy vấn
        // những mẩu tin bị xóa tạm,
        // phương thức get() để lấy kết quả query (là các mẩu tin)
        $posts = Post::onlyTrashed()->get();

        // Dành cho mục đích debug
        // dd($posts);

        // Trả về view nằm trong thư mục admin\posts\trashed.blade.php.
        // Đồng thời truyền biến (tên trashedPosts_view) chứa danh sách các mẩu
        // tin post bị tạm xóa cho view để hiển thị.
        return view('admin.posts.trashed')->with('trashedPosts_view', $posts);
    }


    // Action để xóa bài post đã bị xóa tạm (field deleted_at có giá trị
    // là thời điểm bị xóa) khỏi DB
    public function kill($id) {
        // Phương thức withTrashed() của ORM model chỉ định chỉ truy vấn trên
        // các mẩu tin đã bị xóa tạm (deleted_at khác null).
        // Phương thức where() hoạt động như mệnh đề where trong lệnh SQL, ý
        // nghĩa: chỉ lấy những mẩu tin có field id khớp với giá trị của biến $id.
        // Phương thức get() lấy kết quả truy vấn, tuy nhiên phương thức get() sẽ trả
        // về một mảng các record. Do vậy, nên dùng phương thức first() để lấy mẩu tin
        // kết quả đầu tiên.
        // $deletedPost = Post::withTrashed()->where('id', $id)->get();
        $deletedPost = Post::withTrashed()->where('id', $id)->first();

        // Dành cho debug
        // dd($deletedPost);

        // Xóa file ảnh bài post
            // Kiểm tra xem file ảnh cũ của bài post có tồn tại hay không
            // Helper-function tên public_path của Laravel trả về đường dẫn đầy đủ đến
            // thư mục public của dự án, file ảnh đặt trong thư mục public.
            // Helper-function tên exists kiểm tra sự tồn tại của file.
            // Phương thức getOriginal() giúp lấy giá trị thuộc tính của model
            // mà không thông qua Accessor (làm biến đổi dữ liệu bằng helper-function
            // tên asset, xem Post.php). Nếu qua Accessor đường dẫn sẽ bị sai.
        if (File::exists(public_path($deletedPost->getOriginal('featured')))) {
            // File ảnh cũ tồn tại
            // Xóa file
            File::delete(public_path($deletedPost->getOriginal('featured')));
        }


        // Thực sự xóa mẩu tin khỏi DB. Phương thức forceDelete() của ORM model sẽ xóa
        // mẩu tin khỏi DB
        $deletedPost->forceDelete();

        // Ghi thông báo thành công vào khóa success của session
        Session::flash('success', 'The post was actually deleted from DB.');
        // Điều hướng về trang trước
        return redirect()->back();
    }


    // Action để phục hồi bài post đã bị xóa tạm (field deleted_at có giá trị
    // là thời điểm bị xóa)
    public function restore($id) {
        // Phương thức withTrashed() của ORM model chỉ định chỉ truy vấn trên
        // các mẩu tin đã bị xóa tạm (deleted_at khác null).
        // Phương thức where() hoạt động như mệnh đề where trong lệnh SQL, ý
        // nghĩa: chỉ lấy những mẩu tin có field id khớp với giá trị của biến $id.
        // Phương thức get() lấy kết quả truy vấn, tuy nhiên phương thức get() sẽ trả
        // về một mảng các record. Do vậy, nên dùng phương thức first() để lấy mẩu tin
        // kết quả đầu tiên.
        // $deletedPost = Post::withTrashed()->where('id', $id)->get();
        $deletedPost = Post::withTrashed()->where('id', $id)->first();

        // Dành cho debug
        // dd($deletedPost);

        // Phục hồi mẩu tin bị xóa tạm thành record bình thường. Phương thức
        // restore() của ORM model sẽ chuyển record bị xóa tạm thành record thông thường.
        $deletedPost->restore();

        // Ghi thông báo thành công vào khóa success của session
        Session::flash('success', 'The post was successfully restored.');
        // Điều hướng về trang có route với tên tham chiếu là posts
        return redirect()->route('posts');
    }
}
