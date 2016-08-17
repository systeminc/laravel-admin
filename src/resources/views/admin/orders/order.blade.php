@extends('layouts.admin')

@section('admin-content')

	<h1>Order Info</h1>
	<span class="last-update">
		CREATED: {{$order->created_at}} <br>
		UPDATED: {{$order->updated_at}} <br>
	</span>

	<form action="{{Request::segment(1)}}/orders/save/{{$order->id}}" method="post">
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		
		<label>Status</label>
		<select name="order_status_id">
			@foreach (OrderStatus::all() as $status)
				<option value="{{$status->id}}" @if($status->id==$order->order_status_id) selected @endif>{{$status->title}}</option>
			@endforeach

			@if (empty($order->id))
				<option value="{{$key++}}" selected>{{$key}}</option>
			@endif
		</select>

		<label>Total Price</label>
		<input type="text" value="{{$order->total_price}}{{$order->currency_sign}}" disabled>

		<label>Shipment ( {{$order->currency_sign}} )</label>
		<input type="text" name="shipment_price" value="{{$order->shipment_price}}">

		<label>Currency</label>
		<select name="currency">
			<option value="EUR" @if($order->currency=='EUR') selected @endif>EUR</option>
			<option value="USD" @if($order->currency=='USD') selected @endif>USD</option>
		</select>

		<label>Currency Sign</label>
		<select name="currency_sign">
			<option value="€" @if($order->currency_sign=='€') selected @endif>€</option>
			<option value="$" @if($order->currency_sign=='$') selected @endif>$</option>
		</select>

		<label>Proforma Invoice Valid Until</label>
		<input type="text" name="valid_until" value="{{$order->valid_until ? $order->valid_until->format('Y-m-d') : ''}}" class="datepicker">

		<label>Invoice Number</label>
		<input type="text" name="invoice_number" value="{{$order->invoice_number}}" placeholder="Last one used is {{$max_invoice_number}}">

		<label>Date of purchase</label>
		<input type="text" name="date_of_purchase" value="{{$order->date_of_purchase ? $order->date_of_purchase->format('Y-m-d') : ''}}" class="datepicker">

		<label>Parity</label>
		<input type="text" name="parity" value="{{$order->parity}}">

		<label>Term of Payment</label>
		<input type="text" name="term_of_payment" value="{{$order->term_of_payment}}">

		<label>Footer text</label>
		<input type="text" name="footnote" value="{{$order->footnote}}">

		<label>Note</label>
		<input type="text" name="note" value="{{$order->note}}">

		<label>
			Show Shipping Address
			<input type="checkbox" name="show_shipping_address" value="1" @if ($order->show_shipping_address) checked @endif>
		</label>



		<br><br><br>
		<h2>Billing Info</h2>

		<label>Billing Name</label>
		<input type="text" name="billing_name" value="{{$order->billing_name}}">
		<label>Billing Email</label>
		<input type="text" name="billing_email" value="{{$order->billing_email}}">
		<label>Billing Telephone</label>
		<input type="text" name="billing_telephone" value="{{$order->billing_telephone}}">
		<label>Billing Address</label>
		<input type="text" name="billing_address" value="{{$order->billing_address}}">
		<label>Billing City</label>
		<input type="text" name="billing_city" value="{{$order->billing_city}}">
		<label>Billing Country</label>
		<input type="text" name="billing_country" value="{{$order->billing_country}}">
		<label>Billing Postcode</label>
		<input type="text" name="billing_postcode" value="{{$order->billing_postcode}}">
		<label>Billing Contact Person</label>
		<input type="text" name="billing_contact_person" value="{{$order->billing_contact_person}}">


		<br><br>
		<h2>Shipping Info</h2>

		<label>Shipping Name</label>
		<input type="text" name="shipping_name" value="{{$order->shipping_name}}">
		<label>Shipping Email</label>
		<input type="text" name="shipping_email" value="{{$order->shipping_email}}">
		<label>Shipping Telephone</label>
		<input type="text" name="shipping_telephone" value="{{$order->shipping_telephone}}">
		<label>Shipping Address</label>
		<input type="text" name="shipping_address" value="{{$order->shipping_address}}">
		<label>Shipping City</label>
		<input type="text" name="shipping_city" value="{{$order->shipping_city}}">
		<label>Shipping Country</label>
		<input type="text" name="shipping_country" value="{{$order->shipping_country}}">
		<label>Shipping Postcode</label>
		<input type="text" name="shipping_postcode" value="{{$order->shipping_postcode}}">
		<label>Shipping Contact Person</label>
		<input type="text" name="shipping_contact_person" value="{{$order->shipping_contact_person}}">

		<input type="submit" value="Save">
	</form>

		<br><br><br>
		<h2>Order Items</h2>

		@foreach ($order->items as $item)
			<form action="{{Request::segment(1)}}/orders/edit-item/{{$item->id}}" method="post" class="order-items-form">
				<input type="hidden" name="_token" value="{{csrf_token()}}">

				<span class="title">{{$item->tool->title}}</span>
				
				<label>Quantity</label>
				<input type="text" name="quantity" value="{{$item->quantity}}">
				
				<label>Discount</label>
				<input type="text" name="discount" value="{{$item->discount}}"><span>{{$order->currency_sign}}</span>
				
				<label>Custom Price</label>
				<input type="text" name="custom_price" value="{{$item->custom_price}}"><span>{{$order->currency_sign}}</span>

				<div class="actions">
					<input type="submit" value="Save">
					<a href="{{Request::segment(1)}}/orders/delete-item/{{$item->id}}" class="confirm-action">Delete?</a>
				</div>
			</form>
		@endforeach

		<br>
		<form action="{{Request::segment(1)}}/orders/add-item/{{$order->id}}" method="post" class="new-order-item-form">
			<input type="hidden" name="_token" value="{{csrf_token()}}">

			<select name="tool_id">
				@foreach (Tool::all() as $tool)
					<option value="{{$tool->id}}">{{$tool->title}}</option>
				@endforeach				
			</select>

			<input type="submit" value="Add new item">
		</form>

@stop