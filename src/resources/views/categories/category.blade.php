@extends('admin::layouts.admin')

@section('admin-content')

	<h1>Category Info</h1>

	<form action="shop/categories/save/{{$category->id or 'new'}}" method="post" enctype="multipart/form-data">
		<input type="hidden" name="_token" value="{{csrf_token()}}">

		<label>Title</label>
		<input type="text" name="title" value="{{$category->title}}">

		<label>Subtitle</label>
		<input type="text" name="subtitle" value="{{$category->subtitle}}">

		<label>URI</label>
		<input type="text" name="uri" value="{{$category->uri}}" disabled>

		<label>Excerpt</label>
		<textarea name="excerpt" class="htmlEditorTools" rows="5">{{$category->excerpt}}</textarea>

		<label>Description</label>
		<textarea name="description" class="htmlEditor" rows="15" data-page-id="{{$category->uri}}">{{$category->description}}</textarea>

		<label>Thumbnail</label>
		<div class="file-input-wrap cf">
			@if(!empty($category->thumb)) 
				<div class="small-image-preview" style="background-image: url({{$category->thumb}})"></div>
				<input type="checkbox" name="delete_thumb">Delete this file?
			@else
				<div class="fileUpload">
					<span>Choose file</span>
					<input type="file" name="thumb"/>
				</div>
			@endif
		</div>

		<label>Menu Order</label>
		<select name="menu_order">
			@foreach ($categories as $key => $value)
				<option value="{{$key}}" @if($key==$category->menu_order) selected @endif>{{$key}}</option>
			@endforeach

			@if (empty($category->id))
				<option value="0" selected>0</option>
			@endif
		</select>

		<label>SEO Title</label>
		<input type="text" name="seo_title" value="{{$category->seo_title}}">

		<label>SEO Description</label>
		<input type="text" name="seo_description" value="{{$category->seo_description}}">

		<label>SEO Keywords</label>
		<input type="text" name="seo_keywords" value="{{$category->seo_keywords}}">

		<input type="submit" value="Save">

		@if ($category->id)
			<a class="button remove-item" href="shop/categories/delete/{{$category->id}}">Delete</a>
		@endif
	</form>

@stop