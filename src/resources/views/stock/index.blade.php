@extends('admin::layouts.admin')

@section('admin-content')

	<div class="admin-header">
		<h1>Stock</h1>
		<span class="last-update"></span>
	</div>

	<div class="admin-content">
		@if (!empty($products->first()))
		
			<table class="stock-table">
				<tr>
					<th>Title</th>
					<th>Stock</th>
					<th>Ordered</th>
					<th>Need</th>
					<th>Sold</th>
				</tr>
			@foreach ($products as &$product)
				<tr>
					<td><a href="shop/products/edit/{{$product->id}}">{{$product->title}}</a></td>
					<td>{{$product->stock}}</td>
					<td>{{$product->ordered}}</td>
					<td>{{$product->need}}</td>
					<td>{{$product->sold}}</td>
				</tr>
			@endforeach
			</table>

		@else
			<p>You don't have any Product yet so stock is empty</p>
		@endif
		
		
	</div>


@stop