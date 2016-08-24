<h2>Gallery</h2>

	<form style="max-width: 100%;" action="galleries/update/{{ $product->gallery->title }}" class="images" method="post" enctype="multipart/form-data">
		{{ csrf_field() }}
		<label for="title">Title:</label>
		<input type="text" name="title" value="{{ $product->gallery->title }}">	

		<div class="gallery-wrap">
			<ul class="image-list sortable cf" data-link="ajax/{{ $product->gallery->title }}/change-gallery-order">
				@foreach ($product->gallery->images as $image)
					<li class="items-order" data-id="{{$image->id}}">
						<div class="buttons">
							<div onclick="ajaxDeleteGalleryImage('ajax/{{ $product->gallery->title }}/delete-gallery-images/{{ $image->id }}', '{{$image->id}}')" class="button remove-image delete">Delete</div>
						</div>
						<img src="uploads/{{$image->source}}" />
					</li>
				@endforeach
			</ul>
		</div>	

	    <div class="fileUpload">
			<span>Add image</span>
			<input type="file" name="images[]" multiple="multiple">
		</div>
	</form>

<script>
	$(".fileUpload input").change(function(event) {
		$(this).closest('form').submit();
	});
</script>