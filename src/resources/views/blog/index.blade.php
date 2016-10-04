@extends('admin::layouts.admin')

@section('admin-content')
	
	<div class="admin-header">
		<h1>Latest Posts</h1>
		<span class="last-update"></span>
		<div class="button-wrap">
			<a href="blog/post-new" class="button right">Add new</a>
		</div>
	</div>

	<div class="admin-content">

		@if (session('success'))
		    <span class="alert alert-success">
		        {{ session('success') }}
		    </span>
		@endif
		
		@if (!empty($posts->first()))
			<ul>
			@foreach ($posts as &$post)
				<li><a href="blog/post-edit/{{$post->id}}">{{$post->title}}</a></li>
			@endforeach
			</ul>

			{!! $posts->render() !!}
		@endif	



		@if (!empty($comments->first()))
			<div class="section-header">
				<span>Latest Comments</span>
				<div class="line"></div>
			</div>
		
			<ul class="comments border">
			@foreach ($comments as &$comment)

				<li class="cf @if(!$comment->approved)disapproved @endif">
					<a class="article-title" href="blog/post-edit/{{$comment->post->id}}" target="_blank">{{$comment->post->title}}</a>
					<div class="name">{{$comment->name}} / {{$comment->email}}</div>
					<p>{{$comment->content}}</p>
					<div class="created_at">{{$comment->created_at->format('Y-m-d H:i')}}h</div>

					@if ($comment->approved)
						<a class="action button" href="blog/disapprove-comment/{{$comment->id}}">Disapprove</a>
					@else
						<a class="action button disapproved" href="blog/approve-comment/{{$comment->id}}">Approve</a>
					@endif
				</li>
			@endforeach
			</ul>

		{!! $comments->render() !!}
		@endif	
		
		
	</div>
	

@stop