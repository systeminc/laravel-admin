@extends('admin::layouts.admin')

@section('admin-content')
	
	<h1>Products Comments</h1>
	<span class="last-update"></span>
	
	<ul class="comments">
	@foreach ($comments as &$comment)
		<li class="@if(!$comment->approved)disapproved @endif">
			<a class="product-title" href="shop/product/{{$comment->product->url_id}}" target="_blank">{{$comment->product->title}}</a>
			<div class="name">{{$comment->name}} / {{$comment->email}}</div>
			<p>{{$comment->message}}</p>
			<div class="created_at">{{$comment->created_at->format('Y-m-d H:i')}}h</div>

			@if ($comment->approved)
				<a class="action" href="products-comments/disapprove/{{$comment->id}}">Disapprove</a>
			@else
				<a class="action disapproved" href="products-comments/approve/{{$comment->id}}">Approve</a>
			@endif
		</li>
	@endforeach
	</ul>

	{!! $comments->render() !!}
@stop