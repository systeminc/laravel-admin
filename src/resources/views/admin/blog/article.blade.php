@extends('admin_layouts.admin')

@section('admin-content')

	<section>	
		<h1>{{$article->title}}</h1>
		<span class="last-update">Last change: {{ $article->updated_at->tz('CET')->format('d M Y, H:i\h') }}</span>

		@if (session('success'))
		    <span class="alert alert-success">
		        {{ session('success') }}
		    </span>
		@endif

		<form action="{{Request::segment(1)}}/blog/save/{{$article->id or 'new'}}" method="post" enctype="multipart/form-data">
			<input type="hidden" name="_token" value="{{csrf_token()}}">

			<label>Title</label>
			<input type="text" name="title" value="{{$article->title}}">

			<label>URI ID</label>
			<input type="text" name="uri_id" value="{{$article->uri_id}}">

			<label>Excerpt</label>
			<textarea name="excerpt" rows="5">{{$article->excerpt}}</textarea>

			<label>Content</label>
			<textarea name="content" class="htmlEditor" rows="15" data-page-id="blog/{{$article->id}}">{{$article->content}}</textarea>

			<label>Thumbnail</label>
			<div class="file-input-wrap cf">
				@if(!empty($article->thumb)) 
					<div class="small-image-preview" style="background-image: url({{$article->thumb}})"></div>
					<input type="checkbox" name="delete_thumb">Delete this file?
				@else
					<div class="fileUpload">
						<span>Choose file</span>
						<input type="file" name="thumb"/>
					</div>
				@endif
			</div>

			<label>SEO Title</label>
			<input type="text" name="meta_title" value="{{$article->meta_title}}">

			<label>SEO Description</label>
			<input type="text" name="meta_description" value="{{$article->meta_description}}">

			<label>SEO Keywords</label>
			<input type="text" name="meta_keywords" value="{{$article->meta_keywords}}">

			<label>Visible</label>
			<select name="visible">
				<option value="0" @if(!$article->visible) selected @endif>Not Visible</option>
				<option value="1" @if($article->visible) selected @endif>Visible</option>
			</select>

			<div class="cf"></div>

			<input type="submit" value="Save">

			@if ($article->id)
				<a class="button remove-item" href="{{Request::segment(1)}}/blog/delete/{{$article->id}}">Delete</a>
			@endif

		</form>
	</section>

@stop
