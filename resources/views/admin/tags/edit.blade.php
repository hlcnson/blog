@extends('layouts.app')


@section('content')

	<!-- Bao gồm đoạn mã nguồn hiển thị lỗi trong file 
	admin/includes/errors.blade.php tại đây. -->
	@include('admin.includes.errors')

	<div class="panel panel-default">
		<div class="panel-heading">
			Edit tag: {{ $tag_view->tag }}
		</div>
		<div class="panel-body">

			<!-- Sử dụng phương thức route để tự động tạo route bao gồm 
			cả phần prefix (nếu có) dựa trên tên tham chiếu của route (định
			nghĩa trong file web.php) -->
			<!-- Truyền tham số id của tag cho route.  -->
			<!-- $tag_view là đối tượng tag được controller truyền sang. -->
			<form action="{{ route('tag.update', ['id' => $tag_view->id]) }}" method="post">
				<!-- Phương thức để tạo token giúp server xác định được
				dữ liệu do chính ứng dụng gửi về -->
				{{ csrf_field() }}

				<!-- Thuộc tính name của các điều khiển phải khớp với 
				cấu trúc field trong migration -->
				<div class="form-group">
					<label for="tag">Tag</label>
					<input type="text" name="tag" id="tag" class="form-control" value="{{ $tag_view->tag }}">
				</div>

				<input class="form-control btn btn-success" type="submit" value="Update tag">
			</form>
		</div>
	</div>

@stop