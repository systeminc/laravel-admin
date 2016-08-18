@extends('admin_layouts.admin')

@section('admin-content')
	
	<h1>Categories</h1>
	<a href="{{Request::segment(1)}}/categories/new" class="button right">Add new</a>
	<span class="last-update"></span>
	
	<ul>
	@foreach ($categories as &$category)
		<li><a href="{{Request::segment(1)}}/categories/edit/{{$category->id}}"><b>{{$category->title}}</a></li>
	@endforeach
	</ul>

@stop