@extends('admin::layouts.admin')

@section('admin-content')
	
	<h1>Categories</h1>
	<a href="shop/categories/new" class="button right">Add new</a>
	<span class="last-update"></span>
	
	<ul>
	@foreach ($categories as &$category)
		<li><a href="shop/categories/edit/{{$category->id}}"><b>{{$category->title}}</a></li>
	@endforeach
	</ul>

@stop