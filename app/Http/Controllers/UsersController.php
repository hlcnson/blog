<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Import model class 
use App\User;
use App\Profile;
use Session;

class UsersController extends Controller
{
    public function __construct(){
        // Kích hoạt middleware tên admin. Với middleware này, các phương thức trong 
        // controller này sẽ không thể được truy cập bởi user không phải admin.
        // Vì vậy, tất cả các route truy cập vào các action của controller này 
        // sẽ bị chặn bởi middleware.
        $this->middleware('admin');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Action hiển thị view danh mục users
        // Phương thức all() để lấy mọi record (có field deleted_at mang giá trị null)
        // trong table Posts
        $users = User::all();

        // Trả về view nằm trong thư mục admin\users\index.blade.php.
        // Đồng thời truyền biến (tên users_view) chứa danh sách các mẩu 
        // tin user cho view để hiển thị. 
        return view('admin.users.index')->with('users_view', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Action tạo user mới

        // Trả về view nằm trong thư mục admin\users\create.blade.php.
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Action này lưu trữ bài viết vào Database

        // Dành cho mục đích debug
        // dd($request->all());

        // Phương thức validate (được kế thừa từ các base class) có chức năng 
        // kiểm tra dữ liệu.
        // Tham số thứ nhất: Dữ liệu để kiểm tra, trong đôi tượng $request
        // Tham số thứ 2: Mảng các rule để kiểm tra data, dành cho các field trong
        // đối tượng request do trình duyệt post về. Trường hợp này, $request được
        // post về từ form để thêm user mới.
        // Nếu một field có nhiều hơn một rule, ngăn cách chúng bằng dấu | (pipe).
        // Ý nghĩa rule:
        //      required: Bắt buộc có
        //      max:255    Tối đa 255 ký tự
        //      image       Phải là hình ảnh
        // 
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email'
        ]);

        // Tạo đối tượng user mới
        // Đây là một cách
        // $user = new User;

        // Đây là cách nhanh hơn. Phương thức create kế thừa từ class Model (Eloquent Model).
        // Phương thức này nhận một đối số là một mảng với các chỉ mục trùng khớp với cấu 
        // trúc table trong DB (xem phần migration của model).
        // Phương thức này tạo đối tượng model mới và insert nó vào database.
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);  // Phương thức bcrypt để mã hóa password

        // Phương thức create() ở trên có thể tạo ra lỗi bảo mật Massive-assignment (lỗi
        // gán quá nhiều thuộc tính model cùng lúc). Gán giá trị cho thuộc tính fillable của 
        // model để chỉ định field được phép mass-assign hoặc thuộc tính guarded để chỉ
        // định field không được mass-assign.

        // Tạo đối tượng profile cho user
        $profile = Profile::create([
            'user_id' => $user->id,
            'avatar' => 'uploads/avatars/avatar1.jpg'
        ]);

        // Ghi thông điệp báo thêm bài post thành công vào Session của ứng dụng với khóa
        // là success.
        Session::flash('success', 'New user created successfully');

        // Điều hướng về route users
        return redirect()->route('users');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Action để xóa tài khoản user

        // Xác định mẩu tin tương ứng với tài khoản user 
        $user = User::find($id);
        // Xóa mẩu tin profile tương ứng với user
        $user->profile->delete();
        // Xóa mẩu tin tài khoản user
        $user->delete();
        // Ghi thông điệp báo đã xóa tài khoản user
        Session::flash('success', 'User deleted.');
        // Điều hướng trang trước
        return redirect()->back();
    }

    // Action chuyển user thành admin, nhận đối số là id của user
    public function admin($id){
        // Xác định mẩu tin trong DB tương ứng với user
        $user = User::find($id);
        // Thay đổi field admin thành true
        $user->admin = 1;
        // Lưu vào DB
        $user->save();
        // Ghi thông điệp báo thêm bài post thành công vào Session của ứng dụng với khóa
        // là success.
        Session::flash('success', 'Permission changed successfully');
        // Điều hướng về route users
        return redirect()->route('users');
    }


    // Action chuyển admin thành user thường, nhận đối số là id của user
    public function not_admin($id){
        // Xác định mẩu tin trong DB tương ứng với user
        $user = User::find($id);
        // Thay đổi field admin thành false
        $user->admin = 0;
        // Lưu vào DB
        $user->save();
        // Ghi thông điệp báo thêm bài post thành công vào Session của ứng dụng với khóa
        // là success.
        Session::flash('success', 'Permission changed successfully');
        // Điều hướng về route users
        return redirect()->route('users');
    }
}
