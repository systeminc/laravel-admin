@extends('admin::layouts.admin')

@section('admin-content')

	<h1>Gallery {{ $gallery->title }}</h1>

	<form style="max-width: 100%;" action="galleries/update/{{ $gallery->title }}" method="post" enctype="multipart/form-data">
		{{ csrf_field() }}
		<label for="title">Title:</label>
		<input type="text" name="title" value="{{ $gallery->title }}">	

		<div class="gallery-wrap">
			<ul class="image-list sortable cf" data-link="ajax/{{ $gallery->title }}/change-gallery-order">
				@foreach ($images as $image)
					<li class="items-order" data-id="{{$image->id}}">
						<div class="buttons">
							<div onclick="ajaxDeleteGalleryImage('ajax/{{ $gallery->title }}/delete-gallery-images/{{ $image->id }}', '{{$image->id}}')" class="button remove-image delete">Delete</div>
						</div>
						<img src="{{$image->source}}" />
					</li>
				@endforeach
			</ul>
		</div>	

	    <div class="fileUpload">
			<span>Add image</span>
			<input type="file" name="images[]" multiple="multiple">
		</div>
		<a class="button right" href="galleries/delete/{{ $gallery->title }}">Delete gallery</a>
	</form>

<script>
	$(".fileUpload input").change(function(event) {
		$(this).parents('form').submit();
	});
</script>
@stop