@extends('admin::layouts.admin')

@section('admin-content')
	
	<h1>Categories</h1>
	<a href="blog/categories/new" class="button right">Add new</a>
	<span class="last-update"></span>
	
	<ul>
	@foreach ($blogs as &$blog)
		<li><a href="blog/categories/edit/{{$blog->id}}"><b>{{$blog->title}}</a></li>
	@endforeach
	</ul>

@stop