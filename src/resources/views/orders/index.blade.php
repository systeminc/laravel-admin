@extends('admin::layouts.admin')

@section('admin-content')

	<div class="admin-header">
		<h1>Orders</h1>
		<span class="last-update"></span>
	</div>

	<div class="admin-content">
		<button class="button toggle-filters">Filters</button>
		<a href="{{Request::fullUrl()}}{{Request::getQueryString() ? '&' : '?'}}print_pdf=1" class="button" style="background: none;"><img src="images/pdf-icon.png" style="height: 20px;vertical-align: middle;"></a>

		<form action="/{{Request::segment(1)}}/shop/orders" class="filters" {!!empty(Request::input('filter')) ? '' : 'style="display:block;"'!!}>
			<div>
				<input type="text" name="filter[search]" placeholder="Search" value="{{Request::input('filter.search')}}">
				<label><input type="radio" name="filter[search_column]" value="billing_name" checked>name</label>
				<label><input type="radio" name="filter[search_column]" value="billing_contact_person" 
					{{Request::input('filter.search_column')=='billing_contact_person' ? 'checked' : ''}}>contact person</label>
				<label><input type="radio" name="filter[search_column]" value="billing_country"
					{{Request::input('filter.search_column')=='billing_country' ? 'checked' : ''}}>country</label>
				<label><input type="radio" name="filter[search_column]" value="billing_email"
					{{Request::input('filter.search_column')=='billing_email' ? 'checked' : ''}}>email</label>
			</div>
	 
			<div>
				<input type="text" name="filter[date_from]" class="datepicker" placeholder="From date" style="margin-right:0"
					value="{{Request::input('filter.date_from')}}">{{-- 
			--}}<input type="text" name="filter[date_to]" class="datepicker" placeholder="To date"
					value="{{Request::input('filter.date_to')}}">
			</div>

			<div>
				<select name="filter[price_comparison_sign]" style="margin-right:0">
					<option value="=" {{Request::input('filter.price_comparison_sign')=='=' ? 'selected' : ''}}>=</option>
					<option value="<" {{Request::input('filter.price_comparison_sign')=='<' ? 'selected' : ''}}>&lt;</option>
					<option value=">" {{Request::input('filter.price_comparison_sign')=='>' ? 'selected' : ''}}>&gt;</option>
				</select>{{-- 
			--}}<input type="text" name="filter[total_price]" placeholder="Price" 
					value="{{Request::input('filter.total_price')}}">

				<select name="filter[currency]">
					<option value="" disabled selected>Currency</option>
					<option value="EUR" {{Request::input('filter.currency')=='EUR' ? 'selected' : ''}}>EUR</option>
					<option value="USD" {{Request::input('filter.currency')=='USD' ? 'selected' : ''}}>USD</option>
				</select>

				<select name="filter[order_status_id]" placeholder="Status">
					<option value="" disabled selected>Status</option>
					@foreach (SystemInc\LaravelAdmin\OrderStatus::all() as $status)
						<option value="{{$status->id}}" {{Request::input('filter.order_status_id')==$status->id ? 'selected' : ''}}>{{$status->title}}</option>
					@endforeach
				</select>

				<a href="{{Request::segment(1)}}/orders" class="button" style="float:right;">RESET</a>
				<input type="submit" class="button dark" value="SUBMIT">
			</div>

			<div></div>
		</form>
		
		@if (!empty($orders->first()))

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
				@if ($order->status->id == SystemInc\LaravelAdmin\OrderStatus::DELIVERED)
					<tr class='blue'>
				@elseif ($order->status->id == SystemInc\LaravelAdmin\OrderStatus::CREATED)
					<tr class='green'>
				@elseif ($order->status->id == SystemInc\LaravelAdmin\OrderStatus::NOT_ACCEPTED)
					<tr class='red'>
				@else
					<tr>
				@endif
					<td>{{$order->id}}</td>
					<td>{{$order->status->title}}</td>
					<td>{{$order->billing_name}}</td>
					<td>{{$order->billing_email}}</td>
					<td>{{$order->total_price + $order->total_price * (empty(config('laravel-admin.invoice.vat')) ? '0' : config('laravel-admin.invoice.vat'))/100 }} {{$order->currency}}</td>
					<td style="font-weight: bold">{{$order->invoice_number ?: ''}}</td>
					<td class="actions">
						<a href="shop/orders/preview-proforma/{{$order->id}}" target="_blank" class="button">Preview</a>
						<a href="shop/orders/send-proforma/{{$order->id}}" class="confirm-action button">Send</a>
					</td>
					<td class="actions">
						<a href="shop/orders/preview-invoice/{{$order->id}}" target="_blank" class="button">Preview</a>
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

		@else
			<p>You don't have any orders yet</p>
		@endif
		
		
	</div>
<script>
	$(".toggle-filters").click(function(event) {
		$('.filters').slideToggle();
	});
</script>
@stop