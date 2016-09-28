@extends('admin::layouts.admin')

@section('admin-content')

	<div class="admin-header">
		<h1>Categories</h1>
		<span class="last-update"></span>
		<div class="button-wrap">
			<a href="blog/categories/new" class="button right">Add new</a>
		</div>
	</div>

	<div class="admin-content">
		<ul class="border">
		@foreach ($blogs as &$blog)
			<li><a href="blog/categories/edit/{{$blog->id}}"><b>{{$blog->title}}</a></li>
		@endforeach
		</ul>
		
		
	</div>
	
	

@stop