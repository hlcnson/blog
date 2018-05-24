
<!-- Sử dụng layout chính trong file view/layouts/app.blade.php -->
@extends('layouts.app')

<!-- Phần nội dung của view sẽ được đặt vào layout chính ở đây -->
@section('content')

	<div class="panel panel-default">
		<div class="panel-heading">
			Categories
		</div>
		<div class="panel-body">
			<table class="table table-hover">
				<thead>
					<th>
						Category name
					</th>
					<th>
						Editting
					</th>
					<th>
						Deleting
					</th>
				</thead>
				<tbody>
					<!-- Kiểm tra có mẩu tin để hiển thị hay không -->
					@if ($categories_view->count() > 0)
						<!-- Loop qua biến $categories_view chứa các category do 
						controller truyền sang để hiển thị từng category trong table -->
						@foreach ($categories_view as $category)
							<tr>
								<td>{{ $category->name }}</td>
								<td>
									<!-- Phương thức route() để tạo route có tên tham chiếu
									là category.delete (route kích hoạt form edit cho category). Đối số thứ hai của phương thức route()
									là mảng chứa đối số id (tham số của route) của category để edit -->
									<a href="{{ route('category.edit', ['id' => $category->id]) }}" class="btn btn-xs btn-info">
										Edit
									</a>
								</td>
								<td>
									<!-- Phương thức route() để tạo route có tên tham chiếu
									là category.delete (route kích hoạt action xóa category). Đối số thứ hai của phương thức route()
									là mảng chứa đối số id của category để xóa -->
									<a href="{{ route('category.delete', ['id' => $category->id]) }}" class="btn btn-xs btn-danger">
										Delete
									</a>
								</td>
							</tr>
						@endforeach
					@else
						<tr>
							<td colspan="3" class="text-center">No categories yet.</td>
						</tr>
					@endif
					
				</tbody>
			</table>
		</div>
	</div>

@stop
<!-- Kết thúc view -->