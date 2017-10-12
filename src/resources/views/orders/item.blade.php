@extends('admin::layouts.admin')

@section('admin-content')

	<div class="admin-header">
		<h1>Order product info</h1>
		<span class="last-update">Last change: {{$orderItem->updated_at->tz('CET')->format('d M Y, H:i\h')}}</span>
	</div>

	<div class="admin-content">

		<div class="one-box">
			<div class="background-image" style="background-image: url({{ !empty($orderItem->product->thumb) ? Storage::url($orderItem->product->thumb) : 'images/no-image.svg' }})"></div>
		</div>

		<div class="one-box">
			<p><b>Product Title:</b> {{ !empty($orderItem->product->title) ? $orderItem->product->title : 'Not define' }}</p>
			<p><b>SKU:</b> {{ !empty($orderItem->product->sku) ? $orderItem->product->sku : 'Not define' }}</p>
			<p><b>Product price:</b> {{ !empty($orderItem->product->price) ? $orderItem->product->price : 'Not define' }}</p>
			<p><b>Product shipment price:</b> {{ !empty($orderItem->product->shipment_price) ? $orderItem->product->shipment_price : 'Not define' }}</p>
			<p><b>On stock:</b> {{ !empty($orderItem->product->stock) ? $orderItem->product->stock : 'Not define' }}</p>
		</div>

		<h2>Variations</h2>

		<ul class="border">
			@foreach ($orderItem->variations as &$variation)
				<li><a href='shop/products/edit-variation/{{ $variation->productVariation->id }}'>
				@if (!empty($variation->productVariation->image)) <img src="{{ Storage::url($variation->productVariation->image)}}"> @endif
				<b>
				@if (!empty($variation->productVariation->title)) Title: {{$variation->productVariation->title}} @endif
				@if (!empty($variation->productVariation->group)) | Group: {{$variation->productVariation->group}} @endif
				@if (!empty($variation->productVariation->key)) | Key: {{$variation->productVariation->key}} @endif
				@if (!empty($variation->productVariation->price)) | Price: {{$variation->productVariation->price}} @endif
				@if (!empty($variation->productVariation->content)) | Content: {{substr(strip_tags($variation->productVariation->content), 0 , 50)}} @endif
				</b></a></li>
			@endforeach
		</ul>

		<section>
			<section>
				@includeIf('sla.order.item')
			</section>
		</section>
		<a href="{{ url()->previous() }}" class="button back-button">Back</a>
	</div>
@stop