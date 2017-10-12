@extends('admin::layouts.admin')

@section('admin-content')

	<div class="admin-header">
		<h1>Category Info</h1>
		<span class="last-update">{{ empty($category->updated_at) ? "" : 'Last change: '.$category->updated_at->tz('CET')->format('d M Y, H:i\h') }}</span>
		<div class="button-wrap">
			<a href="shop/categories/new" class="button right">Add new</a>
		</div>
	</div>

	<div class="admin-content">
		<form action="blog/categories/save/{{ $category->id or 'new'}}" method="post" enctype="multipart/form-data">
			{{ csrf_field() }}

				@if ($errors->first('title'))
				    <div class="alert alert-error no-hide">
				        <span class="help-block">
				            <strong>{{ $errors->first('title') }}</strong>
				        </span>
				    </div>
				@endif 

			<label>Title</label>
			<input type="text" name="title" value="{{ $category->title or old('title') }}">

				@if ($errors->first('subtitle'))
				    <div class="alert alert-error no-hide">
				        <span class="help-block">
				            <strong>{{ $errors->first('subtitle') }}</strong>
				        </span>
				    </div>
				@endif 

			<label>Subtitle</label>
			<input type="text" name="subtitle" value="{{$category->subtitle or old('subtitle')}}">

				@if ($errors->first('slug'))
				    <div class="alert alert-error no-hide">
				        <span class="help-block">
				            <strong>{{ $errors->first('slug') }}</strong>
				        </span>
				    </div>
				@endif 		

			<label>Slug</label>
			<input type="text" name="slug" value="{{$category->slug or old('slug')}}">

			<label>Excerpt</label>
			<textarea name="excerpt" class="htmlEditorTools" rows="5">{{$category->excerpt or old('excerpt')}}</textarea>

				@if ($errors->first('description'))
				    <div class="alert alert-error no-hide">
				        <span class="help-block">
				            <strong>{{ $errors->first('description') }}</strong>
				        </span>
				    </div>
				@endif 

			<label>Description</label>
			<textarea name="description" class="htmlEditor" rows="15" data-page-name="category" data-page-id="{{$category->id}}" id="editor-{{ str_replace('.', '', $category->id) }}">{{$category->description or old('description')}}</textarea>

			<label>Thumbnail</label>
			<div class="file-input-wrap cf">
				@if(!empty($category->thumb)) 
					<div class="small-image-preview" style="background-image: url({{ Storage::url($category->thumb)}})"></div>
					<input type="checkbox" name="delete_thumb">Delete this file?
				@else
					<div class="fileUpload">
						<span>Choose file</span>
						<input type="file" name="thumb" class="upload" />
					</div>
				@endif
			</div>

			<label>Menu Order</label>

			<div class="select-style">
				<select name="menu_order">
					@foreach ($blogs as $key => $value)
						<option value="{{$key}}" @if($key==$category->menu_order) selected @endif>{{$key}}</option>
					@endforeach
				
					@if (empty($category->id))
						<option value="0" selected>0</option>
					@endif
				</select>
			</div>
			<div class="cf"></div>
			<br>

			<label>SEO Title</label>
			<input type="text" name="seo_title" value="{{$category->seo_title or old('seo_title')}}">

			<label>SEO Description</label>
			<input type="text" name="seo_description" value="{{$category->seo_description or old('seo_description')}}">

			<label>SEO Keywords</label>
			<input type="text" name="seo_keywords" value="{{$category->seo_keywords or old('seo_keywords')}}">

			<input type="submit" value="Save" class="save-item">

			@if ($category->id)
				<a class="button remove-item" href="blog/categories/delete/{{$category->id}}">Delete</a>
			@endif
			<a href="{{ url()->previous() }}" class="button back-button">Back</a>			
		</form>
		
		<script>
			
			$('input[name="title"]').keyup(function() {
				$('input[name="slug"]').val($(this).val().replace(' ', '-'));
			})
		</script>
		
		
	</div>


@stop