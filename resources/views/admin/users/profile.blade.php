@extends('layouts.app')


@section('content')

	<!-- Bao gồm đoạn mã nguồn hiển thị lỗi trong file 
	admin/includes/errors.blade.php tại đây. -->
	@include('admin.includes.errors')

	<div class="panel panel-default">
		<div class="panel-heading">
			Edit your profile
		</div>
		<div class="panel-body">

			<!-- Sử dụng phương thức route để tự động tạo route bao gồm 
			cả phần prefix (nếu có) dựa trên tên tham chiếu của route (định
			nghĩa trong file web.php) -->
			
			<form action="{{ route('user.profile.update') }}" method="post" enctype="multipart/form-data">
				<!-- Phương thức để tạo token giúp server xác định được
				dữ liệu do chính ứng dụng gửi về -->
				{{ csrf_field() }}

				<!-- Thuộc tính name của các điều khiển phải khớp với 
				cấu trúc field trong migration -->
				<div class="form-group">
					<label for="name">User name</label>
					<input type="text" name="name" class="form-control" value="{{ $user_view->name }}">
				</div>
				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" name="email" class="form-control" value="{{ $user_view->email }}">
				</div>
				<div class="form-group">
					<label for="password">New password</label>
					<input type="password" name="password" class="form-control">
				</div>
				<div class="form-group">
					<label for="avatar">Upload new avatar</label>
					<input type="file" name="avatar" class="form-control">
				</div>
				<div class="form-group">
					<label for="facebook">Facebook profile</label>
					<input type="text" name="facebook" value="{{ $user_view->profile->facebook }}" class="form-control">
				</div>
				<div class="form-group">
					<label for="youtube">Youtube profile</label>
					<input type="text" name="youtube" value="{{ $user_view->profile->youtube }}" class="form-control">
				</div>
				<div class="form-group">
					<label for="about">About you</label>
					<textarea name="about" cols="6" rows="6" class="form-control">{{ $user_view->profile->about }}</textarea>
				</div>

				<input class="form-control btn btn-success" type="submit" value="Update profile">
			</form>
		</div>
	</div>

@stop

