<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    // /**
    //  * Create a new controller instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     // Inject middleware tại đây để bảo vệ controller. Mọi phương thức trong
    //     // controller này sẽ được bảo vệ bởi middleware tên auth, các phương thức
    //     // chỉ cho phép người dùng đã được chứng thực truy cập.
    //     $this->middleware('auth');
    // }

    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Trả về view tên home
        return view('home');
    }
}
