@extends('admin::layouts.admin')

@section('admin-content')

	<div class="admin-header">
		<h1>Galleries</h1>
		<span class="last-update">Last change: 06 Sep, 2016, 11:38h</span>
		
	</div>

	<div class="admin-content">
		@foreach ($page->galleries()->get() as $gallery)
		<div class="gallery-wrap">
			<label>{{ $gallery->title }}</label>

			<div class="gallery-images sortable" data-gallery-id="{{ $gallery->id }}">
			@foreach ($gallery->images()->orderBy('order')->get() as $image)
				<a href="ajax/delete-gallery-image/{{$image->id}}" class="remove-item no-transition"><img src="{{$image->source}}" data-image-id="{{$image->id}}"></a>
			@endforeach
			</div>
			
			<form action="ajax/upload-gallery-image" method="post" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="gallery_id" value="{{ $gallery->id }}">

				<div class="fileUpload">
					<span>Add image</span>
					<input type="file" name="images[]" multiple />
				</div>
			</form>
		</div>
		@endforeach

		<script>
			$(".gallery-wrap .fileUpload input").change(function(event) {
				$(this).parents('form').submit();
			});

			$(".sortable").sortable({
				stop: function( event, ui ) {
					var holder = $(this);

					var order = [];

					holder.find('[data-image-id]').each(function(index, el) {
						order.push($(this).data('image-id'));
					});

					var data = {
						gallery_id: holder.data('gallery-id'),
						order: order,
						_token: '{{csrf_token()}}',
					}

					$.post('ajax/order-gallery-images', data);
				}
			});
		</script>
		
		
	</div>



@stop