@extends('admin::layouts.admin')

@section('admin-content')

	<div class="admin-header">
		<h1>Order Info</h1>
		<span class="last-update">Last change: {{$order->updated_at->tz('CET')->format('d M Y, H:i\h')}}</span>
	</div>

	<div class="admin-content">
		<form action="shop/orders/save/{{$order->id}}" method="post">
			{{ csrf_field() }}
			
			@if ($errors->first('order_status_id'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('order_status_id') }}</strong>
			        </span>
			    </div>
			@endif 

			<div class="cf">
				<label>Status</label>
				<div class="select-style">
					<select name="order_status_id">
						@foreach ($statuses as $status)
							<option value="{{$status->id}}" @if($status->id==$order->order_status_id) selected @endif>{{$status->title}}</option>
						@endforeach
					
						@if (empty($order->id))
							<option value="{{$key++}}" selected>{{$key}}</option>
						@endif
					</select>
				</div>
			</div>

			<label>Total Price</label>
			<input type="text" value="{{$order->total_price + $order->total_price * (empty(config('laravel-admin.invoice.vat')) ? '0' : config('laravel-admin.invoice.vat'))/100 }} {{$order->currency}}" disabled>

			@if ($errors->first('shipment_price'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('shipment_price') }}</strong>
			        </span>
			    </div>
			@endif 

			<label>Shipment ( {{$order->currency}} )</label>
			<input type="text" name="shipment_price" value="{{old('shipment_price') ?: $order->shipment_price}}">

			@if ($errors->first('currency'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('currency') }}</strong>
			        </span>
			    </div>
			@endif 
			
			<div class="cf">
				<label>Currency</label>
				<div class="select-style">
					<select name="currency">
						<option value="EUR" @if($order->currency=='EUR') selected @endif>EUR</option>
						<option value="USD" @if($order->currency=='USD') selected @endif>USD</option>
					</select>
				</div>
			</div>

			<label>Proforma Invoice Valid Until</label>
			<input type="text" name="valid_until" value="{{old('valid_until') ?: $order->valid_until->format('Y-m-d')}}" class="datepicker">

			@if ($errors->first('invoice_number'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('invoice_number') }}</strong>
			        </span>
			    </div>
			@endif

			@if (session('error'))
		        <div class="alert alert-error no-hide">
		            <span class="help-block">
		                <strong>{{ session('error') }}</strong>
		            </span>
		        </div>
		    @endif

			<label>Invoice Number</label>
			<input type="text" name="invoice_number" value="{{old('invoice_number') ?: $order->invoice_number}}" placeholder="Last one used is {{$max_invoice_number}}">

			<label>Date of purchase</label>
			<input type="text" name="date_of_purchase" value="{{old('date_of_purchase') ?: $order->date_of_purchase->format('Y-m-d')}}" class="datepicker">

			@if ($errors->first('parity'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('parity') }}</strong>
			        </span>
			    </div>
			@endif 

			<label>Parity</label>
			<input type="text" name="parity" value="{{old('parity') ?: $order->parity}}">

			@if ($errors->first('term_of_payment'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('term_of_payment') }}</strong>
			        </span>
			    </div>
			@endif 

			<label>Term of Payment</label>
			<input type="text" name="term_of_payment" value="{{old('term_of_payment') ?: $order->term_of_payment}}">

			@if ($errors->first('footnote'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('footnote') }}</strong>
			        </span>
			    </div>
			@endif 

			<label>Footer text</label>
			<input type="text" name="footnote" value="{{old('footnote') ?: $order->footnote}}">
{{-- {{dd($errors->first('note'))}} --}}
{{-- {{dd($errors->first('billing_telephone'))}} --}}
			@if ($errors->first('note'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('note') }}</strong>
			        </span>
			    </div>
			
			@endif 

			<label>Note</label>
			<input type="text" name="note" value="{{old('note') ?: $order->note}}">

			@if ($errors->first('show_shipping_address'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('show_shipping_address') }}</strong>
			        </span>
			    </div>
			@endif 

			<label>
				Show Shipping Address
				<input type="checkbox" name="show_shipping_address" value="1" @if ($order->show_shipping_address) checked @endif>
			</label>



			<br>
			<div class="section-header">
				<span>Billing Info</span>
				<div class="line"></div>
			</div>
			<br><br>

			@if ($errors->first('billing_name'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('billing_name') }}</strong>
			        </span>
			    </div>
			@endif

			<label>Billing Name</label>
			<input type="text" name="billing_name" value="{{old('billing_name') ?: $order->billing_name}}">

			@if ($errors->first('billing_email'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('billing_email') }}</strong>
			        </span>
			    </div>
			@endif 

			<label>Billing Email</label>
			<input type="text" name="billing_email" value="{{old('billing_email') ?: $order->billing_email}}">
			@if ($errors->first('billing_telephone'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('billing_telephone') }}</strong>
			        </span>
			    </div>
			@endif 

			<label>Billing Telephone</label>
			<input type="text" name="billing_telephone" value="{{old('billing_telephone') ?: $order->billing_telephone}}">

			@if ($errors->first('billing_address'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('billing_address') }}</strong>
			        </span>
			    </div>
			@endif 

			<label>Billing Address</label>
			<input type="text" name="billing_address" value="{{old('billing_address') ?: $order->billing_address}}">

			@if ($errors->first('billing_city'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('billing_city') }}</strong>
			        </span>
			    </div>
			@endif 

			<label>Billing City</label>
			<input type="text" name="billing_city" value="{{old('billing_city') ?: $order->billing_city}}">

			@if ($errors->first('billing_country'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('billing_country') }}</strong>
			        </span>
			    </div>
			@endif 

			<label>Billing Country</label>
			<input type="text" name="billing_country" value="{{old('billing_country') ?: $order->billing_country}}">

			@if ($errors->first('billing_postcode'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('billing_postcode') }}</strong>
			        </span>
			    </div>
			@endif 

			<label>Billing Postcode</label>
			<input type="text" name="billing_postcode" value="{{old('billing_postcode') ?: $order->billing_postcode}}">

			@if ($errors->first('billing_contact_person'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('billing_contact_person') }}</strong>
			        </span>
			    </div>
			@endif 

			<label>Billing Contact Person</label>
			<input type="text" name="billing_contact_person" value="{{old('billing_contact_person') ?: $order->billing_contact_person}}">


			<br>
			<div class="section-header">
				<span>Shipping Info</span>
				<div class="line"></div>
			</div>
			<br><br>

			<label>Shipment id</label>
			<input type="text" name="shipment_id" value="{{old('shipment_id') ?: $order->shipment_id}}">

			@if ($errors->first('shipping_name'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('shipping_name') }}</strong>
			        </span>
			    </div>
			@endif 

			<label>Shipping Name</label>
			<input type="text" name="shipping_name" value="{{old('shipping_name') ?: $order->shipping_name}}">

			@if ($errors->first('shipping_email'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('shipping_email') }}</strong>
			        </span>
			    </div>
			@endif 

			<label>Shipping Email</label>
			<input type="text" name="shipping_email" value="{{old('shipping_email') ?: $order->shipping_email}}">

			@if ($errors->first('shipping_telephone'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('shipping_telephone') }}</strong>
			        </span>
			    </div>
			@endif 

			<label>Shipping Telephone</label>
			<input type="text" name="shipping_telephone" value="{{old('shipping_telephone') ?: $order->shipping_telephone}}">

			@if ($errors->first('shipping_address'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('shipping_address') }}</strong>
			        </span>
			    </div>
			@endif 

			<label>Shipping Address</label>
			<input type="text" name="shipping_address" value="{{old('shipping_address') ?: $order->shipping_address}}">

			@if ($errors->first('shipping_city'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('shipping_city') }}</strong>
			        </span>
			    </div>
			@endif 

			<label>Shipping City</label>
			<input type="text" name="shipping_city" value="{{old('shipping_city') ?: $order->shipping_city}}">

			@if ($errors->first('shipping_country'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('shipping_country') }}</strong>
			        </span>
			    </div>
			@endif 

			<label>Shipping Country</label>
			<input type="text" name="shipping_country" value="{{old('shipping_country') ?: $order->shipping_country}}">

			@if ($errors->first('shipping_postcode'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('shipping_postcode') }}</strong>
			        </span>
			    </div>
			@endif 

			<label>Shipping Postcode</label>
			<input type="text" name="shipping_postcode" value="{{old('shipping_postcode') ?: $order->shipping_postcode}}">

			@if ($errors->first('shipping_contact_person'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('shipping_contact_person') }}</strong>
			        </span>
			    </div>
			@endif 

			<label>Shipping Contact Person</label>
			<input type="text" name="shipping_contact_person" value="{{old('shipping_contact_person') ?: $order->shipping_contact_person}}">

			<input type="submit" value="Save" class="save-item">
		</form>

		<br>
		<div class="section-header">
			<span>Order Items</span>
			<div class="line"></div>
		</div>
		<br><br>

		<ul class="order-items-form-wrap">
			
			@foreach ($order->items as $item)
				<li>
					<form action="shop/orders/edit-item/{{$item->id}}" method="post" class="order-items-form">
						<input type="hidden" name="_token" value="{{csrf_token()}}">
				
						<a href="shop/orders/view-item/{{ $item->id }}">
							<span class="title">{{$item->product->title}}</span>
						</a>
						
						<div class="cf">
							<label>Quantity</label>
							<input type="text" name="quantity" value="{{$item->quantity}}">
							
							<div class="order-box">
								<label>Discount</label>
								<input type="text" name="discount" value="{{$item->discount}}"><span>{{$order->currency}}</span>
							</div>
							
							<div class="order-box">
								<label>Custom Price</label>
								<input type="text" name="custom_price" value="{{$item->custom_price}}"><span>{{$order->currency}}</span>
							</div>
							
							<div class="action-wrap">
								<input type="submit" value="Save" class="save-item button" style="max-width: 100px;">
								<a href="shop/orders/delete-item/{{$item->id}}" class="confirm-action button remove-item">Delete</a>
							</div>
						</div>
					</form>
				</li>
			@endforeach
		</ul>


		<br><br>
		<form action="shop/orders/add-item/{{$order->id}}" method="post" class="new-order-item-form">
			<input type="hidden" name="_token" value="{{csrf_token()}}">

			<div class="cf">
				<div class="select-style">
					<select name="product_id">
						@foreach ($products as $product)
							<option value="{{$product->id}}">{{$product->title}}</option>
						@endforeach				
					</select>
				</div>
			</div>

			<input type="submit" value="Add new item" class="save-item">
		</form>
		
		<a href="{{ url()->previous() }}" class="button back-button">Back</a>
	</div>



@stop