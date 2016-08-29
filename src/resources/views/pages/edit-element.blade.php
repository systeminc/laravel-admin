@extends('admin::layouts.admin')

@section('admin-content')

	<h1>Edit {{ $element->title }} element</h1>	
	<span class="last-update"></span>

		<form action="pages/update-element/{{ $element->id }}" method="post" enctype="multipart/form-data">
			{{ csrf_field() }}
		
			@if ($errors->first('title'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('title') }}</strong>
			        </span>
			    </div>
			@endif 
		
			<label>Title</label>
			<input type="text" name="title" placeholder="Page title" value="{{ $element->title or old('title') }}">
		
			@if ($errors->first('content'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('content') }}</strong>
			        </span>
			    </div>
			@endif 
		
			@if ($element->page_element_type_id == 1 || old('page_element_type_id') == 1)

				<label>Content</label>
				<textarea name="content" class="htmlEditor" rows="5" placeholder="Content">{{ $element->content or old('content') }}</textarea>
				
			@elseif ($element->page_element_type_id == 2 || old('page_element_type_id') == 2)

				<label>Content</label>
				<textarea name="content" class="htmlEditor" rows="5" placeholder="Content">{{ $element->content or old('content') }}</textarea>

				<script>
					$( document ).ready(function() {
						setTimeout(function(){
							$(".mce-i-code").click(); // trigger code content							
						},500);
					});					
				</script>

			@elseif ($element->page_element_type_id == 3 || old('page_element_type_id') == 3)

				@if (strstr($mime, 'image') !== false)
					<img src="uploads/{{ $element->content }}" alt="" width="200" class="left">
				@elseif ($mime !== null)
					<a href="uploads/{{ $element->content }}" download class="button left">{{ $element->title }}</a>
				@endif

				@if (empty($element->content))
					
				    <div class="fileUpload">
						<span>Add file</span>
						<input type="file" name="content">
					</div>
				@else
					<input type="hidden" name="content" value="{{ $element->content }}">
					<a href="pages/delete-element-file/{{ $element->id }}" class="button remove-item left">Delete file</a>
				@endif
			@endif

			<input type="submit" value="Update">
			
			<a href="pages/delete-element/{{ $element->id }}" class="button remove-item right">Delete Element</a>
		</form>

@stop