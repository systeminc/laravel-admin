@extends('admin::layouts.admin')

@section('admin-content')
	<div class="admin-header">
		<h1>Gallery {{ $image->title }}</h1>
		<span class="last-update">Last change: {{$image->updated_at->tz('CET')->format('d M, Y, H:i\h')}}</span>
	</div>

	<div class="admin-content">
		<div class="cf" style="position: relative">
			<img src="{{ Storage::url($image->source) }}" alt="" style="max-width: 200px; width: 100%; background-color: #ddd;" class="left">
		</div>
		
		<br>
		<h2>Replace image</h2>

		<form style="max-width: 100%;" action="galleries/update/{{ $image->gallery->id }}/{{ $image->id }}" method="post" enctype="multipart/form-data">
			{{ csrf_field() }}
		    <div class="fileUpload cf">
				<span>Add replacement image</span>
				<input type="file" name="images[]">
			</div>
			<input type="hidden" name="key" value="{{ $image->gallery->key }}">	
			<input type="hidden" name="title" value="{{ $image->gallery->title }}">	
		</form>

		<div class="cf">
			<div class="section-header">
				<span>Elements</span>
				<div class="line"></div>
			</div>

			@if (!empty($image->getAllElements()->first()))
				
				<ul class="elements-list sortable" data-link="ajax/{{ $image->id }}/change-gallery-image-element-order">
					@foreach ($image->getAllElements()->get() as $element)
						<li class="items-order" data-id="{{$element->id}}">
							<a href="galleries/images/edit-element/{{$element->id}}"><b>{{ ucfirst($element->title) }} @php echo env('APP_ENV') == 'local' ? ' - '.$element->key : '' @endphp</b></a>
							<a href="galleries/images/delete-element/{{ $element->id }}" class="button remove-item file delete list">Delete</a>
						</li>
					@endforeach
				</ul>
			@else
				<p>No elements yet</p>
			@endif
			
				<form action="galleries/images/new-element/{{ $image->id }}" method="post">
					{{ csrf_field() }}

					<div class="select-style">
						<select name="page_element_type_id" class="element-type">
							<option value="0">Add element</option>
						
							@foreach ($element_types as $element_type)
								<option value="{{ $element_type->id }}">{{ $element_type->title }}</option>
							@endforeach
						</select>
					</div>
				</form>
		</div>
		@if (!empty($image->gallery->product))
			<a href="shop/products/edit/{{ $image->gallery->product->id }}" class="button back-button">Back</a>
		@else
			<a href="galleries/edit/{{ $image->gallery->id }}" class="button back-button">Back</a>
		@endif
	</div>

	<script>
		$("body").delegate('.element-type', 'change',function(){

			if ($(this).val() == 0) {
				return false;
			}
			else {
				$(this).closest("form").submit();
			}
		});

		$(".fileUpload input").change(function(e) {
			e.preventDefault();
			$(this).parents('form').submit();
		});
	</script>
@stop