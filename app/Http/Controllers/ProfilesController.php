<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use File;

class ProfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Action hiển thị profile của user đã được chứng thực

        // Trả về view nằm trong thư mục admin\users\profile.blade.php.
        // Đồng thời truyền biến (tên user_view) là đối tượng user đã được chứng thực 
        // cho view để hiển thị. 
        return view('admin.users.profile')->with('user_view', Auth::user());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request)
    {
        // Action này lưu trữ thông tin cập nhật của profile vào Database

        // Dành cho mục đích debug
        // dd($request->all());

        // Phương thức validate (được kế thừa từ các base class) có chức năng 
        // kiểm tra dữ liệu.
        // Tham số thứ nhất: Dữ liệu để kiểm tra, trong đôi tượng $request
        // Tham số thứ 2: Mảng các rule để kiểm tra data, dành cho các field trong
        // đối tượng request do trình duyệt post về. Trường hợp này, $request được
        // post về từ form cập nhật profile, có các field tên: name,
        // email, password, avatar, facebook, youtube, about (xem migration của bảng Users và Profiles).
        // Nếu một field có nhiều hơn một rule, ngăn cách chúng bằng dấu | (pipe).
        // Ý nghĩa rule:
        //      required: Bắt buộc có
        //      max:255    Tối đa 255 ký tự
        //      url       Phải là một URL
        // 
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'facebook' => 'required|url',
            'youtube' => 'required|url'
        ]);

        // Lấy đối tượng user đang đăng nhập (đã chứng thực)
        $user = Auth::user();
        // LƯU FILE ẢNH AVATAR
        // Phương thức hasFile() kiểm tra xem user có upload file ảnh avatar hay không. 
        // avatar là name của điều khiển upload file trên view.
        if ($request->hasFile('avatar')) {
            // Có file được upload lên => lưu file

            // Lấy image từ đối tượng $request
            $avatar = $request->avatar;

            // Tạo tên mới cho file image bằng cách ghép thời điểm hiện tại với tên gốc của file
            $avatar_new_name = time() . $avatar->getClientOriginalName();

            // Lưu trữ file ảnh avatar của user vào thư mục uploads/avatars với tên mới 
            // tạo ở trên
            $avatar->move('uploads/avatars', $avatar_new_name);

            // Kiểm tra xem file ảnh avatar cũ của user có tồn tại hay không
            // Helper-function tên public_path của Laravel trả về đường dẫn đầy đủ đến
            // thư mục public của dự án, file ảnh đặt trong thư mục public.
            // Helper-function tên exists kiểm tra sự tồn tại của file.
            if (File::exists(public_path($user->profile->avatar))) {
                // File ảnh cũ tồn tại
                // Xóa file
                File::delete(public_path($user->profile->avatar));
            }
            // dd(public_path($post->getOriginal('featured')));

            // Cập nhật lại tên file ảnh trong DB
            $user->profile->avatar = 'uploads/avatars/' . $avatar_new_name;
            // Lưu dữ liệu vào table Profiles
            $user->profile->save();
        }

        // LƯU CÁC THÔNG TIN PROFILE
        $user->name = $request->name;
        $user->email = $request->email;
        $user->profile->facebook = $request->facebook;
        $user->profile->youtube = $request->youtube;
        $user->profile->about = $request->about;

        // Kiểm tra có password được post về hay không
        if ($request->has('password')){
            $user->password = bcrypt($request->password);
        }

        // Lưu vào bảng Users
        $user->save();
        // Lưu vào bảng Profiles
        $user->profile->save();
        // Ghi thông báo vào Session
        Session::flash('success', 'Your profile updated successfully');
        // Điều hướng về trang trước
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // 
    }
}
