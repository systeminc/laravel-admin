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
		<ul class="border sortable" data-link="ajax/change-product-categories-order">
			@foreach ($categories as &$category)
				<li class="items-order" data-id="{{$category->id}}"><a href="shop/categories/edit/{{$category->id}}"><b>{{$category->title}}</b></a></li>
			@endforeach
		</ul>
		
		
	</div>
	
	

@stop