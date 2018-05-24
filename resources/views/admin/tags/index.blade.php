
<!-- Sử dụng layout chính trong file view/layouts/app.blade.php -->
@extends('layouts.app')

<!-- Phần nội dung của view sẽ được đặt vào layout chính ở đây -->
@section('content')

	<div class="panel panel-default">
		<div class="panel-heading">
			Tags
		</div>
		<div class="panel-body">
			<table class="table table-hover">
				<thead>
					<th>
						Tag name
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
					@if ($tags_view->count() > 0)
						<!-- Loop qua biến $categories_view chứa các tag do 
						controller truyền sang để hiển thị từng tag trong table -->
						@foreach ($tags_view as $tag)
							<tr>
								<td>{{ $tag->tag }}</td>
								<td>
									<!-- Phương thức route() để tạo route có tên tham chiếu
									là tag.delete (route kích hoạt form edit cho tag). Đối số thứ hai của phương thức route()
									là mảng chứa đối số id (tham số của route) của tag để edit -->
									<a href="{{ route('tag.edit', ['id' => $tag->id]) }}" class="btn btn-xs btn-info">
										Edit
									</a>
								</td>
								<td>
									<!-- Phương thức route() để tạo route có tên tham chiếu
									là tag.delete (route kích hoạt action xóa tag). Đối số thứ hai của phương thức route()
									là mảng chứa đối số id của tag để xóa -->
									<a href="{{ route('tag.delete', ['id' => $tag->id]) }}" class="btn btn-xs btn-danger">
										Delete
									</a>
								</td>
							</tr>
						@endforeach
					@else
						<tr>
							<td colspan="3" class="text-center">No tags yet.</td>
						</tr>
					@endif
					
				</tbody>
			</table>
		</div>
	</div>

@stop
<!-- Kết thúc view -->