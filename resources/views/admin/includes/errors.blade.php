<!-- Hiển thị lỗi tại đây. Biến $errors có thể được truy xuất từ mọi 
	view của ứng dụng. Biến $errors sẽ rỗng nếu không có lỗi kiểm tra dữ liệu.
	Nó sẽ có dữ liệu nếu như có lỗi data validation. Biến $errors là một mảng. -->
@if (count($errors) > 0)
	<!-- Có lỗi xảy ra -->
	<ul class="list-group">
		<!-- Hiển thị lỗi -->
		@foreach($errors->all() as $err)
			<li class="list-group-item text-danger">
				{{ $err }}
			</li>
		@endforeach
	</ul>
@endif