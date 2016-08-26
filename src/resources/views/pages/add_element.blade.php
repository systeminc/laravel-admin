@extends('admin::layouts.admin')

@section('admin-content')

	<h1>Add element in {{ $page->title }} page</h1>	
	<span class="last-update"></span>

		<form action="pages/add-element/{{ $page->id }}" method="post" enctype="multipart/form-data">
			{{ csrf_field() }}

			<input type="hidden" name="key" value="{{ $page->title or old('title') }}">
			<input type="hidden" name="page_element_type_id" value="{{ $page_element_type_id or old('page_element_type_id') }}">
		
			@if ($errors->first('title'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('title') }}</strong>
			        </span>
			    </div>
			@endif 
		
			<label>Title</label>
			<input type="text" name="title" placeholder="Page title">
		
			@if ($errors->first('content'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('content') }}</strong>
			        </span>
			    </div>
			@endif 
		
			@if ($page_element_type_id == 1 || old('page_element_type_id') == 1)

				<label>Content</label>
				<textarea name="content" class="htmlEditor" rows="5" placeholder="Content"></textarea>
				
			@elseif ($page_element_type_id == 2 || old('page_element_type_id') == 2)

				<label>Content</label>
				<textarea name="content" class="htmlEditor" rows="5" placeholder="Content"></textarea>

				<script>
					$( document ).ready(function() {
						setTimeout(function(){
							$(".mce-i-code").click(); // trigger code content							
						},500);
					});					
				</script>

			@elseif ($page_element_type_id == 3 || old('page_element_type_id') == 3)

			    <div class="fileUpload">
					<span>Add file</span>
					<input type="file" name="content" multiple="multiple">
				</div>

			@endif
			<input type="submit" value="Insert">
		</form>

@stop