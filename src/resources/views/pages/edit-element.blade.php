@extends('admin::layouts.admin')

@section('admin-content')

	<div class="admin-header">
		<h1>Edit element</h1>	
		<span class="last-update">Last change: {{$element->updated_at->tz('CET')->format('d M, Y, H:i\h')}}</span>
	</div>

	<div class="admin-content">
		<form action="pages/update-element/{{ $element->id }}" method="post" enctype="multipart/form-data">
			{{ csrf_field() }}
		
			@if ($errors->first('title'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('title') }}</strong>
			        </span>
			    </div>
			@endif 
		
			<label>Key</label>
			<div class="input-box-wrap">
				<input type="text" value="{{ $element->key }}" disabled>
				<div class="button">change</div>
				
				<div class="input-popup">
					<p>If you change this you need to change in code as well</p>
					<input type="text" name="key" value="{{ $key }}">
				</div>
			</div>

		
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
				<textarea name="content" rows="5" placeholder="Content">{{ $element->content or old('content') }}</textarea>
				
			@elseif ($element->page_element_type_id == 2 || old('page_element_type_id') == 2)

				<label>Content</label>
				<textarea name="content" class="htmlEditor" rows="5" placeholder="Content">{{ $element->content or old('content') }}</textarea>

			@elseif ($element->page_element_type_id == 3 || old('page_element_type_id') == 3)

				@if (strstr($mime, 'image') !== false)
					<div class="cf" style="position: relative">
						<img src="uploads/{{ $element->content }}" alt="" style="max-width: 200px; width: 100%; background-color: #ddd;" class="left">
						<div class="cf">
							<input type="hidden" name="content" value="{{ $element->content }}">
							<a href="pages/delete-element-file/{{ $element->id }}" class="button remove-item file image left">Delete file</a>
						</div>
					</div>
				@elseif ($mime !== null)
					<div class="cf" style="position: relative">
						<a href="uploads/{{ $element->content }}" download class="button item left">{{ $element->title }}</a>
						<div class="cf">
							<input type="hidden" name="content" value="{{ $element->content }}">
							<a href="pages/delete-element-file/{{ $element->id }}" class="button remove-item file left">Delete file</a>
						</div>
					</div>
				@endif

				@if (empty($element->content))
					
				    <div class="fileUpload">
						<span>Add file</span>
						<input type="file" name="content">
					</div>
				@endif
			@endif
			<br><br>

			<input type="submit" value="Update" class="save-item">
			
			<a href="pages/delete-element/{{ $element->id }}" class="button remove-item">Delete Element</a>
			<a href="{{ url()->previous() }}" class="button back-button">Back</a>
		</form>
	</div>


@stop