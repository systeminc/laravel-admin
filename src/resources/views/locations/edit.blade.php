@extends('admin::layouts.admin')

@section('admin-content')

	<h1>Edit location</h1>
	
	@if (session('success'))
	    <span class="alert alert-success">
	        {{ session('success') }}
	    </span>
	@endif

	<form action="locations/update/{{ $location->id }}" method="post" enctype="multipart/form-data">
		{{ csrf_field() }}

		@if ($errors->first('title'))
		    <div class="alert alert-error no-hide">
		        <span class="help-block">
		            <strong>{{ $errors->first('title') }}</strong>
		        </span>
		    </div>
		@endif 

		<label>Title</label>
		<input type="text" name="title" placeholder="Page title" value="{{ $location->title or old('title') }}">

		<label for="description">Description:</label>
		<textarea name="description" class="htmlEditor" rows="15" data-page-name="description" data-page-id="new" id="editor-1">{{ $location->description or old('description') }}</textarea>
		
		@if ($errors->first('latitude'))
		    <div class="alert alert-error no-hide">
		        <span class="help-block">
		            <strong>{{ $errors->first('latitude') }}</strong>
		        </span>
		    </div>
		@endif 

		<label for="latitude">Latitude:</label>
		<input type="number" name="latitude" placeholder="latitude" value="{{ $location->latitude or old('latitude') }}">

		@if ($errors->first('longitude'))
		    <div class="alert alert-error no-hide">
		        <span class="help-block">
		            <strong>{{ $errors->first('longitude') }}</strong>
		        </span>
		    </div>
		@endif 

		<label for="longitude">Longitude:</label>
		<input type="number" name="longitude" placeholder="longitude" value="{{ $location->longitude or old('longitude') }}">

		<label>Image</label>
		<div class="file-input-wrap cf">
			@if(!empty($location->image)) 
				<div class="small-image-preview" style="background-image: url(uploads/{{$location->image}})"></div>
				<input type="checkbox" name="delete_image">Delete this file?
			@else
				<div class="fileUpload">
					<span>Choose file</span>
					<input type="file" name="image"/>
				</div>
			@endif
		</div>

		<label for="link">Link:</label>
		<input type="text" name="link" placeholder="URL" value="{{ $location->link or old('link') }}">

		<input type="submit" value="Update">
	</form>

	<div>
		<a href="locations/delete/{{ $location->id }}" class="button remove-item left">Delete location</a>
	</div>
@stop