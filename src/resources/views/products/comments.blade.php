@extends('admin::layouts.admin')

@section('admin-content')

	<div class="admin-header">
		<h1>Products Comments</h1>
		<span class="last-update"></span>
	</div>

	<div class="admin-content">
		@if (!empty($comments->first()))
	
		<ul class="comments border">
			@foreach ($comments as &$comment)
				<li class="cf @if(!$comment->approved)disapproved @endif">
					<a class="product-title" href="shop/products/edit/{{$comment->product->id}}" target="_blank">{{$comment->product->title}}</a>
					<div class="name">{{$comment->name}} / {{$comment->email}}</div>
					<p>{{$comment->message}}</p>
					<div class="created_at">{{$comment->created_at->format('Y-m-d H:i')}}h</div>

					@if ($comment->approved)
						<a class="action button" href="shop/comments/disapprove/{{$comment->id}}">Disapprove</a>
					@else
						<a class="action button disapproved" href="shop/comments/approve/{{$comment->id}}">Approve</a>
					@endif
				</li>
			@endforeach
			</ul>

			{!! $comments->render() !!}
		@endif
		
		
	</div>

@stop