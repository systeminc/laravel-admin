@extends('admin::layouts.admin')

@section('admin-content')
	<div class="admin-header">
		<h1>{{$post->title}}</h1>
		<span class="last-update">Last change: {{ $post->updated_at->tz('CET')->format('d M, Y, H:i\h') }}</span>
	</div>

	<div class="admin-content">
		@if (session('success'))
		    <span class="alert alert-success">
		        {{ session('success') }}
		    </span>
		@endif

		<form action="blog/save/{{$post->id or 'new'}}" method="post" enctype="multipart/form-data">
			<input type="hidden" name="_token" value="{{csrf_token()}}">

			<label>Title</label>
			<input type="text" name="title" value="{{$post->title}}">

			<label>Slug</label>
			<input type="text" name="slug" value="{{$post->slug}}">

			<label>Excerpt</label>
			<textarea name="excerpt" rows="5">{{$post->excerpt}}</textarea>

			<label>Content</label>
			<textarea name="content" class="htmlEditor" rows="15" data-page-name="blog" data-page-id="{{$post->id}}" id="editor-{{ str_replace('.', '', $post->id) }}">{{$post->content}}</textarea>

			<div class="cf">
				<label>Blog Category</label>
				<div class="select-style">
					<select name="blog_category_id">
							<option value="0">Choose category</option>
						@foreach ($categories as &$category)
							<option value="{{$category->id}}" @if($category->id==$post->blog_category_id) selected @endif>{{$category->title}}</option>
						@endforeach
					</select>				
				</div>
			</div>

			<label>Thumbnail</label>
			<div class="file-input-wrap cf">
				@if(!empty($post->thumb)) 
					<div class="small-image-preview" style="background-image: url({{ asset('storage') .'/'. $post->thumb}})"></div>
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
			<div class="select-style">
				<select name="visible">
					<option value="0" @if(!$post->visible) selected @endif>Not Visible</option>
					<option value="1" @if($post->visible) selected @endif>Visible</option>
				</select>				
			</div>

			<div class="cf"></div>

			<input type="submit" value="Save" class="save-item">

			@if ($post->id)
				<a class="button remove-item" href="blog/post-delete/{{$post->id}}">Delete</a>
			@endif
			<a href="{{ url()->previous() }}" class="button back-button">Back</a>

		</form>
		
	</div>
	

@stop
