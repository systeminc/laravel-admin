@extends('admin::layouts.admin')

@section('admin-content')

	<div class="admin-header">
		<h1>Category Info</h1>
		<span class="last-update">{{ empty($category->updated_at) ? "" : 'Last change: '.$category->updated_at->tz('CET')->format('d M Y, H:i\h') }}</span>
	</div>

	<div class="admin-content">
		<form action="shop/categories/save/{{ $category->id or 'new'}}" method="post" enctype="multipart/form-data">
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

			<label>Parent Category</label>
			<select name="parent_id">
				<option value="">None</option>
				
				@foreach (\SystemInc\LaravelAdmin\ProductCategory::whereNotIn('id', $category->children->pluck('id')->push($category->id))->get() as $category_option)
					<option value="{{$category_option->id}}" {{$category_option->id==$category->parent_id ? 'selected' : ''}}>{{$category_option->title}}</option>
				@endforeach
			</select>

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

			@if(!empty($category->thumb))
				<label>Thumbnail hover</label>
				<div class="file-input-wrap cf">
					@if(!empty($category->thumb_hover)) 
						<div class="small-image-preview" style="background-image: url({{ Storage::url($category->thumb_hover)}})"></div>
						<input type="checkbox" name="delete_thumb_hover">Delete this file?
					@else
						<div class="fileUpload">
							<span>Choose file</span>
							<input type="file" name="thumb_hover" class="upload" />
						</div>
					@endif
				</div>
			@endif

			<label>Image</label>
			<div class="file-input-wrap cf">
				@if(!empty($category->image)) 
					<div class="small-image-preview" style="background-image: url({{ Storage::url($category->image)}})"></div>
					<input type="checkbox" name="delete_image">Delete this file?
				@else
					<div class="fileUpload">
						<span>Choose file</span>
						<input type="file" name="image" class="upload" />
					</div>
				@endif
			</div>

			@if(!empty($category->image)) 
				<label>Image hover</label>
				<div class="file-input-wrap cf">
					@if(!empty($category->image_hover)) 
						<div class="small-image-preview" style="background-image: url({{ Storage::url($category->image_hover)}})"></div>
						<input type="checkbox" name="delete_image_hover">Delete this file?
					@else
						<div class="fileUpload">
							<span>Choose file</span>
							<input type="file" name="image_hover" class="upload" />
						</div>
					@endif
				</div>
			@endif

			<div class="cf"></div>
			<br>

			<label>Video</label>
			<input type="text" name="video" value="{{$category->video or old('video')}}">

			<label>SEO Title</label>
			<input type="text" name="seo_title" value="{{$category->seo_title or old('seo_title')}}">

			<label>SEO Description</label>
			<input type="text" name="seo_description" value="{{$category->seo_description or old('seo_description')}}">

			<label>SEO Keywords</label>
			<input type="text" name="seo_keywords" value="{{$category->seo_keywords or old('seo_keywords')}}">

			<input type="submit" value="Save" class="save-item">

			@if ($category->id)
				<a class="button remove-item" href="shop/categories/delete/{{$category->id}}">Delete</a>
			@endif
		</form>
		
		<a href="{{ url()->previous() }}" class="button back-button">Back</a>
		
	</div>


<script>
	
	$('input[name="title"]').keyup(function() {
		$('input[name="slug"]').val($(this).val().replace(' ', '-'));
	})
</script>
@stop