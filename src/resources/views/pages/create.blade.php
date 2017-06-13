@extends('admin::layouts.admin')

@section('admin-content')

	<div class="admin-header">
		<h1>Create Page</h1>
		<span class="last-update"></span>
	</div>

	<div class="admin-content">
		@if (session('error'))
		    <span class="alert alert-error">
		        {{ session('error') }}
		    </span>
		@endif

		<form action="pages/save" method="post">
			{{ csrf_field() }}

			@if ($errors->first('title'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('title') }}</strong>
			        </span>
			    </div>
			@endif 

			<label>Title</label>
			<input type="text" name="title" placeholder="Page title" value="{{ old('title') }}">

			@if ($errors->first('elements_prefix'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('elements_prefix') }}</strong>
			        </span>
			    </div>
			@endif 

			<label>Elements Prefix</label>
			<input type="text" name="elements_prefix" placeholder="Elements Prefix" value="{{ old('elements_prefix') }}">

			@if ($errors->first('slug'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('slug') }}</strong>
			        </span>
			    </div>
			@endif 

			<label>Slug</label>
			<input type="text" name="slug" placeholder="Slug" value="{{ old('slug') }}">

			<label>Keywords</label>
			<input type="text" name="keywords" placeholder="Keywords" value="{{ old('keywords') }}">

			@if ($errors->first('description'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('description') }}</strong>
			        </span>
			    </div>
			@endif 

			<label>Description</label>
			<textarea name="description" class="htmlEditorTools" rows="5" placeholder="Description">{{ old('description') }}</textarea>
			
			<div class="cf">
				<label>Parent page</label>

				<div class="select-style">
					<select name="parent_id">
						<option value="">Choose parent page</option>
					
						@foreach ($pages as $parent)
							
							<option value="{{ $parent->id }}" {{ $parent->id == $page_id ? 'selected="selected"' : '' }}>{{ $parent->title }}</option>
							
						@endforeach
					</select>
				</div>
			</div>

			<input type="submit" value="Create" class="save-item">
			<a href="{{ url()->previous() }}" class="button back-button">Back</a>
		</form>
	</div>

	

@stop
