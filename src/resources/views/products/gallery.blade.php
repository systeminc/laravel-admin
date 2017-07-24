<div class="section-header">
	<span>Gallery</span>
	<div class="line"></div>
</div>
<br><br>

<form style="max-width: 100%;" action="galleries/update/{{ $product->gallery->id }}" class="images" method="post" enctype="multipart/form-data">
	{{ csrf_field() }}
	<label for="title">Title:</label>
	<input type="text" name="title" value="{{ $product->title or $product->gallery->title }}">	
	<input type="hidden" name="key" value="{{ $product->gallery->key }}">	
	
	@if( count($product->gallery->images) )
		<div class="gallery-wrap"> 
			<ul class="image-list sortable cf" data-link="ajax/{{ $product->gallery->title }}/change-gallery-order">
				@foreach ($product->gallery->images as $image)
					<li class="items-order" data-id="{{$image->id}}">
						<div class="buttons">
							<div onclick="ajaxDeleteGalleryImage('ajax/{{ $product->gallery->title }}/delete-gallery-images/{{ $image->id }}', '{{$image->id}}')" class="button remove-image delete">Delete</div>
						</div>
						<a href="galleries/image/{{ $product->gallery->id }}/{{ $image->id }}">
							<img src="{{ asset('storage') .'/'. $image->source}}" />
						</a>					
					</li>
				@endforeach
			</ul>
		</div>	
	@endif

    <div class="fileUpload">
		<span>Add image</span>
		<input type="file" name="images[]" multiple="multiple">
	</div>
</form>

<script>
	$(".images .fileUpload input").change(function(event) {
		$(this).closest('form').submit();
	});
</script>
