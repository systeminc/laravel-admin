@extends('admin::layouts.admin')

@section('admin-content')
	
	<div>
		<a href="blog/categories/new" class="button right">Add new</a>
		<h1>Categories</h1>
		<span class="last-update"></span>
	</div>
	
	<ul>
		@foreach ($categories as &$category)
			<li><a href="blog/categories/edit/{{$category->id}}"><b>{{$category->title}}</a></li>
		@endforeach
	</ul>

@stop