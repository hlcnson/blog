@extends('layouts.app')


@section('content')

	<!-- Bao gồm đoạn mã nguồn hiển thị lỗi trong file 
	admin/includes/errors.blade.php tại đây. -->
	@include('admin.includes.errors')

	<div class="panel panel-default">
		<div class="panel-heading">
			Edit post
		</div>
		<div class="panel-body">
			<!-- Sử dụng phương thức route để tự động tạo route bao gồm 
			cả phần prefix (nếu có) dựa trên tên tham chiếu của route (định
			nghĩa trong file web.php).
			Thuộc tính enctype được sử dụng cho mục đích upload file ảnh -->
			<!-- Truyền tham số id của bài post cho route.  -->
			<!-- $post_view là đối tượng post được controller truyền sang. -->
			<form action="{{ route('post.update', ['id' => $post_view->id]) }}" method="post" enctype="multipart/form-data">
				<!-- Phương thức để tạo token giúp server xác định được
				dữ liệu do chính ứng dụng gửi về -->
				{{ csrf_field() }}

				<!-- Thuộc tính name của các điều khiển phải khớp với 
				cấu trúc field trong migration của table tương ứng -->
				<div class="form-group">
					<label for="title">Title</label>
					<input type="text" name="title" id="title" class="form-control" 
					value="{{ $post_view->title }}">
				</div>

				<div class="form-group">
					<label for="featured">Featured image</label>
					<input type="file" name="featured" id="featured" class="form-control">
				</div>

				<div class="form-group">
					<label for="category">Category</label>
					<select class="form-control" name="category_id" id="category">
						<!-- Loop qua biến categories_view do controller truyền sang
						để hiển thị danh sách -->
						@foreach ($categories_view as $category)
							<!-- Dùng cú pháp blade của Laravel.
							Xác định mục chọn của listbox tương ứng với category của bài post:
							Truy cập mối quan hệ với category bằng cú pháp thuộc tính của phương thức
							category() để lấy đối tượng catagory có quan hệ tương ứng với bài post. -->
							<option value="{{ $category->id }}"
								@if ($post_view->category->id == $category->id)
									selected
								@endif
							>{{ $category->name }}</option>
						@endforeach
					</select>
				</div>

				<div class="form-group">
					<label>Select tags</label>
					<!-- Loop qua các mẩu tin của biến tags_view do controller truyền sang
					để hiển thị tên các tag kèm checkbox. -->
					@foreach ($tags_view as $tag)
						<div class="checkbox">
							<label for="tags[]">
								<!-- Đặt name cho control dạng cú pháp mảng để khi có nhiều
								checkbox được chọn giá trị của chúng sẽ được post về
								server ở dạng một mảng các giá trị id của các tag được chọn,
								mảng có tên là tags.
								Xác định thuộc tính checked cho checkbox tag: Lấy tag id từ 
								pivot table qua mối quan hệ tags của đối tượng $post_view -->
								<input name="tags[]" type="checkbox" value="{{ $tag->id }}"
								@foreach ($post_view->tags as $tag_p)
									@if ($tag->id == $tag_p->id)
										checked
									@endif
								@endforeach
								>{{ $tag->tag }}
							</label>
						</div>
					@endforeach
				</div>

				<div class="form-group">
					<label for="content">Content</label>
					<textarea name="content" id="" cols="5" rows="5" class="form-control">{{ $post_view->content }}</textarea>
				</div>

				<input class="form-control btn btn-success" type="submit" value="Update post">
			</form>
		</div>
	</div>

@stop