<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Sử dụng class Session
use Session;

// Sử dụng file model của category
use App\Category;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Phương thức hiển thị danh sách category

        // Trả về view nằm trong file views/admin/categories/index.blade.php.
        // Đồng thời truyền dữ liệu cho view bằng phương thức with. 
        // Phương thức with có 2 đối số. Đối số thứ nhất là chỉ định tên
        // của biến sẽ được sử dụng ở phần view, đối số thứ hai là dữ liệu
        // truyền cho view (qua biến có tên đã được chỉ định ở đối số 1).
        // Phương thức all() của model Category sẽ trả về mọi mẩu tin có
        // trong table Categories.
        return view('admin.categories.index')->with('categories_view', Category::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Phương thức hiển thị form tạo mới Category
        // Trả về view nằm trong thư mục admin\categories\create.blade.php
        return view('admin.categories.create');

        // Trả về view (form tạo category)
        // return view();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Phương thức lưu category mới vào DB

        // Kiểm tra dữ liệu: tên category bắt buộc phải có
        $this->validate($request, [
            'name' => 'required'
        ]);


        // Lệnh dành cho mục đích debug
        // dd($request->all());

        // Tạo đối tượng mới
        $newCategory = new Category;
        // Gán giá trị cho thuộc tính name từ thuộc tính name được post về trong 
        // đối tượng $request
        $newCategory->name = $request->name;
        // Lưu vào DB
        $newCategory->save();

        // Ghi vào khóa success của Session thông điệp để hiển thị trên trang web
        Session::flash('success', 'You successfully created a category!');

        // Điều hướng về route tên categories (hiển thị danh mục category)
        return redirect()->route('categories');
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
        // Phương thức để hiển thị form edit category

        // Dùng phương thức find kế thừa từ class Model của Laravel để lấy
        // mẩu tin category từ DB.
        $category = Category::find($id);


        // Trả về view nằm trong file views/admin/categories/edit.blade.php.
        // Đồng thời truyền dữ liệu cho view bằng phương thức with. 
        // Phương thức with có 2 đối số. Đối số thứ nhất chỉ định tên
        // của biến sẽ được sử dụng ở phần view, đối số thứ hai là dữ liệu
        // truyền cho view (qua biến có tên đã được chỉ định ở đối số 1).
        return view('admin.categories.edit')->with('category_view', $category);
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
        // Phương thức cập nhật dữ liệu category

        // Lấy mẩu tin category cần cập nhật
        $category = Category::find($id);
        // Gán giá trị cho thuộc tính name từ thuộc tính name được post về trong 
        // đối tượng $request
        $category->name = $request->name;
        // Lưu vào DB
        $category->save();

        // Ghi vào khóa success của Session thông điệp để hiển thị trên trang web
        Session::flash('success', 'You successfully updated the category!');

        // Điều hướng về route tên categories (hiển thị danh mục category)
        return redirect()->route('categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Phương thức để xóa category

        // Lấy mẩu tin category cần xóa
        $category = Category::find($id);

        // Xóa các mẩu tin post có liên quan
        foreach ($category->posts as $post) {
            // Do model Post có tính năng soft delete nên không thể dùng phương thức delete,
            // dùng phương thức forceDelete() để xóa thực sự.
            // $post->delete();
            $post->forceDelete();
        }
        // Xóa mẩu tin
        $category->delete();

        // Ghi vào khóa success của Session thông điệp để hiển thị trên trang web
        Session::flash('success', 'You successfully deleted the category!');

        // Điều hướng về route tên categories (hiển thị danh mục category)
        return redirect()->route('categories');
    }
}
