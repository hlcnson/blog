@extends('layouts.app')


@section('content')

	<!-- Bao gồm đoạn mã nguồn hiển thị lỗi trong file 
	admin/includes/errors.blade.php tại đây. -->
	@include('admin.includes.errors')

	<div class="panel panel-default">
		<div class="panel-heading">
			Create a new user
		</div>
		<div class="panel-body">

			<!-- Sử dụng phương thức route để tự động tạo route bao gồm 
			cả phần prefix (nếu có) dựa trên tên tham chiếu của route (định
			nghĩa trong file web.php) -->
			
			<form action="{{ route('user.store') }}" method="post">
				<!-- Phương thức để tạo token giúp server xác định được
				dữ liệu do chính ứng dụng gửi về -->
				{{ csrf_field() }}

				<!-- Thuộc tính name của các điều khiển phải khớp với 
				cấu trúc field trong migration -->
				<div class="form-group">
					<label for="name">User name</label>
					<input type="text" name="name" class="form-control">
				</div>
				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" name="email" class="form-control">
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" name="password" class="form-control">
				</div>

				<input class="form-control btn btn-success" type="submit" value="Add user">
			</form>
		</div>
	</div>

@stop