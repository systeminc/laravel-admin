@extends('admin::layouts.admin')

@section('admin-content')

	<div class="admin-header">
		<h1>Categories</h1>
		<span class="last-update"></span>
		<div class="button-wrap">
			<a href="shop/categories/new" class="button right">Add new</a>
		</div>
	</div>

	<div class="admin-content">
		<ul class="border">
			@foreach ($categories as &$category)
				<li><a href="shop/categories/edit/{{$category->id}}"><b>{{$category->title}}</a></li>
			@endforeach
		</ul>
		
		
	</div>
	
	

@stop