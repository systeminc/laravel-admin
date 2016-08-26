@extends('admin::layouts.admin')

@section('admin-content')

	<h1>Create Page</h1>

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

		<input type="submit" value="Update">
	</form>

	<div>
		<a href="pages/delete/{{ $page->id }}" class="button remove-item left">Delete page</a>
	</div>

	<br>
	<br>
	<br>

	<div>
		<form action="pages/add-element/{{ $page->id }}" method="post">
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
		
			@if ($errors->first('description'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('description') }}</strong>
			        </span>
			    </div>
			@endif 
		
			<label>Description</label>
			<textarea name="description" class="htmlEditor" rows="5" placeholder="Description">{{ $page->description }}</textarea>
		
			<input type="submit" value="Update">
		</form>
	</div>
	
@stop