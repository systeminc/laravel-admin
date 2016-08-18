@extends('admin_layouts.admin')

@section('admin-content')
	
	<h1>Product</h1>
	<a href="{{Request::segment(1)}}/products/new" class="button right">Add new</a>
	<span class="last-update"></span>
	
	<ul>
	@foreach ($products as &$product)
		<li><a href="{{Request::segment(1)}}/products/edit/{{$product->id}}"><b>{{$product->title}}</a></li>
	@endforeach
	</ul>

@stop