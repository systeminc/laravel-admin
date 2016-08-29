@extends('admin::layouts.admin')

@section('admin-content')
	
	<h1>Latest Posts</h1>
	<a href="blog/post-new" class="button right">Add new</a>
	<span class="last-update"></span>
	
	@if (session('success'))
	    <span class="alert alert-success">
	        {{ session('success') }}
	    </span>
	@endif
	
	@if (!empty($posts->first()))
		<ul>
		@foreach ($posts as &$post)
			<li><a href="blog/post-edit/{{$post->id}}"><b>{{$post->title}}</a></li>
		@endforeach
		</ul>

		{!! $posts->render() !!}
	@endif	

	<h1>Latest Comments</h1>
	<span class="last-update"></span>
	
	@if (!empty($comments->first()))
	
		<ul class="comments">
		@foreach ($comments as &$comment)
			<li class="@if(!$comment->approved)disapproved @endif">
				<a class="article-title" href="blog/{{$comment->article->url_id}}" target="_blank">{{$comment->article->title}}</a>
				<div class="name">{{$comment->name}} / {{$comment->email}}</div>
				<p>{{$comment->content}}</p>
				<div class="created_at">{{$comment->created_at->format('Y-m-d H:i')}}h</div>

				@if ($comment->approved)
					<a class="action" href="blog/disapprove-comment/{{$comment->id}}">Disapprove</a>
				@else
					<a class="action disapproved" href="blog/approve-comment/{{$comment->id}}">Approve</a>
				@endif
			</li>
		@endforeach
		</ul>

	{!! $comments->render() !!}
	@endif	

@stop