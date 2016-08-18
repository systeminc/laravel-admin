@extends('admin_layouts.admin')

@section('admin-content')
	
	<h1>Blog Comments</h1>
	<span class="last-update"></span>
	
	<ul class="comments">
	@foreach ($comments as &$comment)
		<li class="@if(!$comment->approved)disapproved @endif">
			<a class="article-title" href="blog/{{$comment->article->url_id}}" target="_blank">{{$comment->article->title}}</a>
			<div class="name">{{$comment->name}} / {{$comment->email}}</div>
			<p>{{$comment->content}}</p>
			<div class="created_at">{{$comment->created_at->format('Y-m-d H:i')}}h</div>

			@if ($comment->approved)
				<a class="action" href="{{Request::segment(1)}}/blog-comments/disapprove/{{$comment->id}}">Disapprove</a>
			@else
				<a class="action disapproved" href="{{Request::segment(1)}}/blog-comments/approve/{{$comment->id}}">Approve</a>
			@endif
		</li>
	@endforeach
	</ul>

	{!! $comments->render() !!}
@stop