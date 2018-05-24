<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Session;

// Đây là middleware tự tạo bằng lệnh:
// php artisan make:middleware Admin

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Đây là phương thức xử lý request được trình duyệt gửi tới


        // Auth::user() trả về user đã được chứng thực (kiểu model User).
        // Truy cập field admin (của model) để xác định user có phải admin không
        if (!Auth::user()->admin){
            // User không phải admin --> ghi thông báo lỗi vào khóa info của session
            Session::flash('info','You do not have permissions to do this action');
            // Điều hướng về trang trước
            return redirect()->back();
        }
        // Trả về request tiếp theo
        return $next($request);
    }
}
