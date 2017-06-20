@extends('admin::layouts.admin')

@section('admin-content')
	<div class="admin-header">
		<h1>Gallery {{ $image->title }}</h1>
		<span class="last-update">Last change: {{$image->updated_at->tz('CET')->format('d M, Y, H:i\h')}}</span>
	</div>

	<div class="admin-content">
		<div class="image-wrap" >
			<img style="max-width: 100%" src="uploads/{{$image->source}}" />
		</div>

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
		<a href="{{ url()->previous() }}" class="button back-button">Back</a>
		
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
</script>
@stop