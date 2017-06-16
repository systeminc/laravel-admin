@extends('admin::layouts.admin')

@section('admin-content')

	<div class="admin-header">
		<h1>Add element in image</h1>	
		<span class="last-update"></span>
	</div>

	<div class="admin-content">
		<form action="galleries/images/add-element/{{ $image_id }}" method="post" enctype="multipart/form-data">
			{{ csrf_field() }}

			<input type="hidden" name="page_element_type_id" value="{{ $page_element_type_id or old('page_element_type_id') }}">
		
			@if ($errors->first('title'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('title') }}</strong>
			        </span>
			    </div>
			@endif 

			<label>Title</label>
			<input type="text" name="title" placeholder="Page title" value="{{ old('title') }}">
		
			@if ($errors->first('content'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('content') }}</strong>
			        </span>
			    </div>
			@endif 
		
			<div class="cf">
				@if ($page_element_type_id == 1 || old('page_element_type_id') == 1)
				
					<label>Content</label>
					<textarea name="content" rows="5" placeholder="Content">{{ old('content') }}</textarea>
					
				@elseif ($page_element_type_id == 2 || old('page_element_type_id') == 2)
				
					<label>Content</label>
					<textarea name="content" class="htmlEditor" data-page-name="image_element" data-page-id="{{ $image_id }}" id="editor-{{ $image_id }}" rows="5" placeholder="Content">{{ old('content') }}</textarea>
				
				@elseif ($page_element_type_id == 3 || old('page_element_type_id') == 3)
				
				    <div class="fileUpload">
						<span>Add file</span>
						<input type="file" name="content" multiple="multiple">
					</div>
				
				@endif
			</div>

			<div class="cf">
				<input type="submit" value="Insert" class="save-item">
				<a href="{{ url()->previous() }}" class="button back-button">Back</a>
			</div>
		</form>
	</div>


@stop