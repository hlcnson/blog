@extends('layouts.app')


@section('content')

	<!-- Bao gồm đoạn mã nguồn hiển thị lỗi trong file 
	admin/includes/errors.blade.php tại đây. -->
	@include('admin.includes.errors')

	<div class="panel panel-default">
		<div class="panel-heading">
			<!-- Truy xuất biến category_view do controller truyền sang -->
			Update category: {{ $category_view->name }}
		</div>
		<div class="panel-body">

			<!-- Sử dụng phương thức route để tự động tạo route bao gồm 
			cả phần prefix (nếu có) dựa trên tên tham chiếu của route (định
			nghĩa trong file web.php). Đối số thứ nhất của phương thức route
			chính là tên tham chiếu (trong web.php) của route cần tạo,
			đối số thứ hai là mảng chứa các tham số route (chính là phần trong
			cặp ngoặc {} trong định nghĩa route ở file web.php)
			và giá trị tương ứng -->
			
			<form action="{{ route('category.update', ['id' => $category_view->id]) }}" method="post">
				<!-- Phương thức để tạo token giúp server xác định được
				dữ liệu do chính ứng dụng gửi về -->
				{{ csrf_field() }}

				<!-- Thuộc tính name của các điều khiển phải khớp với 
				cấu trúc field trong migration -->
				<div class="form-group">
					<label for="name">Name</label>
					<!-- Truy xuất biến category_view do controller truyền sang -->
					<input type="text" name="name" value="{{ $category_view->name }}" class="form-control">
				</div>

				<input class="form-control btn btn-success" type="submit" value="Update category">
			</form>
		</div>
	</div>

@stop