@extends('admin::layouts.admin')

@section('admin-content')

	<div class="admin-header">
		<h1>Product</h1>
		<span class="last-update"></span>
		<div class="button-wrap">
			<a href="shop/products/new" class="button right">Add new</a>
		</div>
	</div>

	<div class="admin-content">
		<ul class="border">
			@foreach ($products as &$product)
				<li><a href="shop/products/edit/{{$product->id}}"><b>{{$product->title}}</a></li>
			@endforeach
		</ul>
		
		
	</div>
	
	

@stop