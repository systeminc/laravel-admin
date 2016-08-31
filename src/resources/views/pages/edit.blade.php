@extends('admin::layouts.admin')

@section('admin-content')

{{ SLA::shop()->orders->create([
	'billing_name'=> 'maki10',
	'billing_email' => 'nemanjammaric@gmail.com']) }}

	<h1>Edit {{ $page->title }} page</h1>

	<form action="pages/update/{{ $page->id }}" method="post">
		{{ csrf_field() }}

		@if ($errors->first('title'))
		    <div class="alert alert-error no-hide">
		        <span class="help-block">
		            <strong>{{ $errors->first('title') }}</strong>
		        </span>
		    </div>
		@endif 

		<label>Title</label>
		<input type="text" name="title" placeholder="Page title" value="{{ $page->title }}">

		@if ($errors->first('uri_key'))
		    <div class="alert alert-error no-hide">
		        <span class="help-block">
		            <strong>{{ $errors->first('uri_key') }}</strong>
		        </span>
		    </div>
		@endif 

		<label>URI</label>
		<input type="text" name="uri_key" placeholder="Url id" value="{{ $page->uri_key }}">

		<label>Keyword</label>
		<input type="text" name="keyword" placeholder="Keyword" value="{{ $page->keyword }}">

		@if ($errors->first('description'))
		    <div class="alert alert-error no-hide">
		        <span class="help-block">
		            <strong>{{ $errors->first('description') }}</strong>
		        </span>
		    </div>
		@endif 

		<label>Description</label>
		<textarea name="description" class="htmlEditorTools" rows="5" placeholder="Description">{{ $page->description }}</textarea>

		<div>
			<label>Parent page</label>

			<select name="parent_id">
				<option value="">Choose parent page</option>

				@foreach ($pages as $key => $parent)
					
					@if ($parent->id !== $page->id)
						<option value="{{ $parent->id }}" {{ $parent->id == $page->parent_id ? 'selected="selected"' : '' }}>{{ $parent->title }}</option>
					@endif
					
				@endforeach
			</select>
		</div>

		<input type="submit" value="Update">
	</form>

	<div>
		<a href="pages/delete/{{ $page->id }}" class="button remove-item left">Delete page</a>
	</div>

	<div>
		<span class="last-update"></span>
		<h1>Added Elements</h1>

		@if (!empty($elements->first()))
			
			<ul>
				@foreach ($elements as $element)
					<li><a href="pages/edit-element/{{$element->id}}"><b>{{ ucfirst($element->title) }} - {{$element->key}}</a></li>
				@endforeach
			</ul>
		@else
			<p>No elements yet</p>
		@endif
	</div>	

	<form action="pages/new-element/{{ $page->id }}" method="post">
		{{ csrf_field() }}

		<select name="page_element_type_id" class="element-type">
			<option value="0">Add element</option>

			@foreach ($element_types as $element_type)
				<option value="{{ $element_type->id }}">{{ $element_type->title }}</option>
			@endforeach
		</select>
	
	</form>
	
<script>
	
	$(".element-type").change(function(){

		if ($(this).val() == 0) {
			return false;
		}
		else {
			$(this).parent().submit();
		}

	});

</script>

@stop