@extends('admin::layouts.admin')

@section('admin-content')

	<section>	
		<h1>{{$post->title}}</h1>
		<span class="last-update">Last change: {{ $post->updated_at->tz('CET')->format('d M Y, H:i\h') }}</span>

		@if (session('success'))
		    <span class="alert alert-success">
		        {{ session('success') }}
		    </span>
		@endif

		<form action="blog/save/{{$post->id or 'new'}}" method="post" enctype="multipart/form-data">
			<input type="hidden" name="_token" value="{{csrf_token()}}">

			<label>Title</label>
			<input type="text" name="title" value="{{$post->title}}">

			<label>URI ID</label>
			<input type="text" name="uri_id" value="{{$post->uri_id}}">

			<label>Excerpt</label>
			<textarea name="excerpt" rows="5">{{$post->excerpt}}</textarea>

			<label>Content</label>
			<textarea name="content" class="htmlEditor" rows="15" data-page-name="blog" data-page-id="{{$post->id}}" id="editor-{{ str_replace('.', '', $post->id) }}">{{$post->content}}</textarea>

			<label>Blog Category</label>
			<select name="blog_category_id">
					<option value="0">Choose category</option>
				@foreach ($categories as &$category)
					<option value="{{$category->id}}" @if($category->id==$post->blog_category_id) selected @endif>{{$category->title}}</option>
				@endforeach
			</select>

			<label>Thumbnail</label>
			<div class="file-input-wrap cf">
				@if(!empty($post->thumb)) 
					<div class="small-image-preview" style="background-image: url(uploads/{{$post->thumb}})"></div>
					<input type="checkbox" name="delete_thumb">Delete this file?
				@else
					<div class="fileUpload">
						<span>Choose file</span>
						<input type="file" name="thumb"/>
					</div>
				@endif
			</div>

			<label>SEO Title</label>
			<input type="text" name="meta_title" value="{{$post->meta_title}}">

			<label>SEO Description</label>
			<input type="text" name="meta_description" value="{{$post->meta_description}}">

			<label>SEO Keywords</label>
			<input type="text" name="meta_keywords" value="{{$post->meta_keywords}}">

			<label>Visible</label>
			<select name="visible">
				<option value="0" @if(!$post->visible) selected @endif>Not Visible</option>
				<option value="1" @if($post->visible) selected @endif>Visible</option>
			</select>

			<div class="cf"></div>

			<input type="submit" value="Save">

			@if ($post->id)
				<a class="button remove-item" href="blog/post-delete/{{$post->id}}">Delete</a>
			@endif

		</form>
	</section>

@stop
