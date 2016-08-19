@extends('admin::layouts.admin')

@section('admin-content')
	
	<h1>Product</h1>
	<a href="shop/products/new" class="button right">Add new</a>
	<span class="last-update"></span>
	
	<ul>
	@foreach ($products as &$product)
		<li><a href="shop/products/edit/{{$product->id}}"><b>{{$product->title}}</a></li>
	@endforeach
	</ul>

@stop