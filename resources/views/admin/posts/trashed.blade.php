
<!-- Sử dụng layout chính trong file view/layouts/app.blade.php -->
@extends('layouts.app')

<!-- Phần nội dung của view sẽ được đặt vào layout chính ở đây -->
@section('content')

	<div class="panel panel-default">
		<div class="panel-heading">
			Trashed Posts
		</div>
		<div class="panel-body">
			<table class="table table-hover">
				<thead>
					<th>
						Image
					</th>
					<th>
						Title
					</th>
					<th>
						Edit
					</th>
					<th>
						Restore
					</th>
					<th>
						Destroy
					</th>
				</thead>
				<tbody>
					<!-- Kiểm tra xem có biến $trashedPosts_view có mẩu tin hay không -->
					@if ($trashedPosts_view->count() > 0)
						<!-- Loop qua biến $posts_view chứa các bài post do 
						controller truyền sang để hiển thị từng bài post trong HTML table -->
						<!-- Hàm route() của Laravel có chức năng trả về route
						có tên tham chiếu trong đối số thứ nhất được truyền vào cho nó. Các route
						được định nghĩa trong tập tin web.php. Đối số thứ hai là mảng các
						tham số truyền cho route -->
						@foreach ($trashedPosts_view as $post)
							<tr>
								<td>
									<img src="{{ $post->featured }}" alt="{{ $post->title }}" width="90px" height="50px">
								</td>
								<td>{{ $post->title }}</td>
								<td>
									Edit
								</td>
								<td>
									 <a href="{{ route('post.restore', ['id' => $post->id]) }}" class="btn btn-success btn-xs">Restore</a>
								</td>
								<td>
									 <a href="{{ route('post.kill', ['id' => $post->id]) }}" class="btn btn-danger btn-xs">Destroy</a>
								</td>
							</tr>
						@endforeach
					@else
						<tr>
							<td colspan="5" class="text-center">No trashed posts</td>
						</tr>
					@endif
					
				</tbody>
			</table>
		</div>
	</div>

@stop
<!-- Kết thúc view -->