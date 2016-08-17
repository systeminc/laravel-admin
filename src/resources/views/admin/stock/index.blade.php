@extends('admin_layouts.admin')

@section('admin-content')
	
	<h1>Stock</h1>
	<span class="last-update"></span>
	
	<table>
		<tr>
			<th>Title</th>
			<th>Stock</th>
			<th>Ordered</th>
			<th>Need</th>
			<th>Sold</th>
		</tr>
	@foreach ($products as &$product)
		<tr>
			<td><a href="{{Request::segment(1)}}/products/edit/{{$product->id}}"><b>{{$product->title}}</a></td>
			<td style="text-align: center">{{$product->stock}}</td>
			<td style="text-align: center">{{$product->ordered}}</td>
			<td style="text-align: center">{{$product->need}}</td>
			<td style="text-align: center">{{$product->sold}}</td>
		</tr>
	@endforeach
	</table>

@stop