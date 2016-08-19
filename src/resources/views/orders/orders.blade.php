@extends('admin::layouts.admin')

@section('admin-content')
	
	<h1>Orders</h1>
	<span class="last-update"></span>
	
	<table class="order-list">
		<tr>
			<th>ID</th>
			<th>Status</th>
			<th>Billing Name</th>
			<th>Billing Email</th>
			<th>Total</th>
			<th>Invoice number</th>
			<th>Proforma</th>
			<th>Invoice</th>
			<th>Actions</th>
		</tr>
	@foreach ($orders as &$order)
		@if ($order->status->id == 3)
			<tr class='blue'>
		@elseif ($order->status->id == 5)
			<tr class='green'>
		@elseif ($order->status->id == 1)
			<tr class='red'>
		@else
			<tr>
		@endif
			<td>{{$order->id}}</td>
			<td>{{$order->status->title}}</td>
			<td>{{$order->billing_name}}</td>
			<td>{{$order->billing_email}}</td>
			<td style="text-align: right;">{{$order->total_price}}{{$order->currency_sign}}</td>
			<td style="text-align: center; font-weight: bold">{{$order->invoice_number ?: ''}}</td>
			<td class="actions">
				<a href="shop/orders/preview-proforma/{{$order->id}}" class="button">Preview</a>
				<a href="shop/orders/send-proforma/{{$order->id}}" class="confirm-action button">Send</a>
			</td>
			<td class="actions">
				<a href="shop/orders/preview-invoice/{{$order->id}}" class="button">Preview</a>
				<a href="shop/orders/send-invoice/{{$order->id}}" class="confirm-action button">Send</a>
				<a href="shop/orders/print-invoice/{{$order->id}}" class="button">Print</a>
			</td>
			<td class="actions">
				<a href="shop/orders/edit/{{$order->id}}" class="button">Edit</a>
			</td>
		</tr>
	@endforeach
	</table>

	{!! $orders->render() !!}
@stop