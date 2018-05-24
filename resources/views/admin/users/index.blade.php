
<!-- Sử dụng layout chính trong file view/layouts/app.blade.php -->
@extends('layouts.app')

<!-- Phần nội dung của view sẽ được đặt vào layout chính ở đây -->
@section('content')

	<div class="panel panel-default">
		<div class="panel-heading">
			Users
		</div>
		<div class="panel-body">
			<table class="table table-hover">
				<thead>
					<th>
						Image
					</th>
					<th>
						Name
					</th>
					<th>
						Permissions
					</th>
					<th>
						Delete
					</th>
				</thead>
				<tbody>
					<!-- Kiểm tra có mẩu tin hay không -->
					@if ($users_view->count() > 0)
						<!-- Loop qua biến $users_view chứa các user do 
						controller truyền sang để hiển thị từng bài post trong HTML table -->
						<!-- Hàm route() của Laravel có chức năng trả về route
						có tên tham chiếu trong đối số thứ nhất được truyền vào cho nó. Các route
						được định nghĩa trong tập tin web.php. Đối số thứ hai là mảng các
						tham số truyền cho route -->
						@foreach ($users_view as $user)
							<tr>
								<td>
									<!-- Phương thức asset để lấy đường dẫn đầy đủ đến thư mục chứa 
									ảnh avatar, do avatar chỉ chứa đường dẫn từ thư mục uploads. -->
									<img src="{{ asset($user->profile->avatar) }}" alt="{{ $user->name }}" width="60px" height="60px" style="border-radius:50%;">
								</td>
								<td>{{ $user->email }}</td>
								<td>
									<!-- admin là field kiểu boolean -->
									@if ($user->admin)
										<a class="btn btn-danger btn-xs" href="{{ route('user.make.not.admin', ['id' => $user->id]) }}">Remove permission</a>
									@else
										<a class="btn btn-success btn-xs" href="{{ route('user.make.admin', ['id' => $user->id]) }}">Make admin</a>
									@endif
								</td>
								<td>
									<!-- Không cho user tự xóa tài khoản của mình. Phương thức Auth::id() trả về id của user đang đăng nhập-->
									@if(Auth::id() !== $user->id)
										<a class="btn btn-danger btn-xs" href="{{ route('user.delete', ['id' => $user->id]) }}">Delete</a>
									@endif
									
								</td>
							</tr>
						@endforeach
					@else
						<tr>
							<td colspan="5" class="text-center">No users</td>
						</tr>
					@endif
					
				</tbody>
			</table>
		</div>
	</div>

@stop
<!-- Kết thúc view -->