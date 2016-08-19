@extends('admin::layouts.admin')

@section('admin-content')
	
	<h1>Blog</h1>
	<a href="blog/new" class="button right">Add new</a>
	<span class="last-update"></span>
	
		@if (session('success'))
		    <span class="alert alert-success">
		        {{ session('success') }}
		    </span>
		@endif
		
	<ul>
	@foreach ($articles as &$article)
		<li><a href="blog/edit/{{$article->id}}"><b>{{$article->title}}</a></li>
	@endforeach
	</ul>

@stop