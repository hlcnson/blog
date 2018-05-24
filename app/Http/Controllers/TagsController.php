<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

// Sử dụng model Tag
use App\Tag;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Action hiển thị danh mục tag

        // Trả về view tên index.blade.php trong thư mục views/admin/tags
        // Chuyển cho view một biến tên tags_view chứa tất cả mẩu tin tag trong DB
        return view('admin.tags.index')->with('tags_view', Tag::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Action hiển thị view để tạo tag mới

        // Trả về view tên create.blade.php trong thư mục views/admin/tags
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Action để lưu tag vào DB

        // Kiểm tra dữ liệu
        $this->validate($request, [
            'tag' => 'required'
        ]);

        Tag::create([
            'tag' => $request->tag
        ]);

        // Ghi thông báo thành công vào khóa suucess của session
        Session::flash('success', 'New tag created successfully.');
        // Điều hướng về route tên tags
        return redirect()->route('tags');
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
        // Action để hiển thị view cập nhật tag

        // Lấy mẩu tin tương ứng với tag cần cập nhật
        $tag = Tag::find($id);

        // Hiển thị và truyền dữ liệu mẩu tin cho view để cập nhật.
        // View nằm trong đường dẫn views/admin/tags/edit.blade.php
        // Dữ liệu truyền cho view có tên $tag_view
        return view('admin.tags.edit')->with('tag_view', $tag);
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
        // Action để cập nhật dữ liệu tag vào DB

        // Kiểm tra dữ liệu mới của tag trong đối tượng
        // $request được POST về từ form edit: tên tag là bắt buộc phải có
        $this->validate($request, [
            'tag' => 'required'
        ]);

        // Lấy mẩu tin tag tương ứng cần cập nhật
        $tag = Tag::find($id);

        // Cập nhật giá trị mới
        $tag->tag = $request->tag;
        // Lưu vào DB
        $tag->save();
        // Ghi thông báo thành công vào khóa success của session
        Session::flash('success', 'The tag was update successfully.');
        // Điều hướng về route tên tags
        return redirect()->route('tags');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Action để xóa mẩu tin tag khỏi DB (Phương pháp nhanh hơn so với CategriesController)

        // Phương thức destroy xóa mẩu tin có giá trị khóa chính trùng với 
        // đối sô của nó.
        Tag::destroy($id);
        // Ghi thông báo thành công vào khóa success của session
        Session::flash('success', 'The tag was deleted successfully.');
        // Điều hướng về trang trước
        return redirect()->back();
    }
}
