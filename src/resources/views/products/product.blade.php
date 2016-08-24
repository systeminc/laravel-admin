@extends('admin::layouts.admin')

@section('admin-content')

	<section>	
		<h1>{{$product->title}}</h1>
		<span class="last-update">Last change: {{ $product->updated_at->tz('CET')->format('d M Y, H:i\h') }}</span>

		<form action="shop/products/save/{{$product->id or 'new'}}" method="post" enctype="multipart/form-data">
			<input type="hidden" name="_token" value="{{csrf_token()}}">

			<label>Title</label>
			<input type="text" name="title" value="{{$product->title}}">

			<label>URL ID</label>
			<input type="text" name="url_id" value="{{$product->url_id}}">

			<label>Excerpt</label>
			<textarea name="excerpt" rows="5">{{$product->excerpt}}</textarea>

			<label>Description</label>
			<textarea name="description" data-page-name="product" data-page-id="{{$product->id}}" id="editor-{{ str_replace('.', '', $product->id) }}" class="htmlEditor" rows="15">{{$product->description}}</textarea>

			<label>Product Category</label>
			<select name="product_category_id">
				@foreach ($categories as &$category)
					<option value="{{$category->id}}" @if($category->id==$product->product_category_id) selected @endif>{{$category->title}}</option>
				@endforeach
			</select>

			<label>PDF</label>
			<div class="file-input-wrap cf">
				@if(!empty($product->pdf)) 
					<div class="small-image-preview" style="background-image: url('images/pdf-icon.png')"></div>
					<input type="checkbox" name="delete_pdf">Delete this file?
				@else
					<div class="fileUpload">
						<span>Choose file</span>
						<input type="file" name="pdf"/>
					</div>
				@endif
			</div>

			<label>Thumbnail</label>
			<div class="file-input-wrap cf">
				@if(!empty($product->thumb)) 
					<div class="small-image-preview" style="background-image: url(uploads/{{$product->thumb}})"></div>
					<input type="checkbox" name="delete_thumb">Delete this file?
				@else
					<div class="fileUpload">
						<span>Choose file</span>
						<input type="file" name="thumb"/>
					</div>
				@endif
			</div>

			<label>Animation Link</label>
			<input type="text" name="animation" value="{{$product->animation}}">

			<label>Video Link</label>
			<input type="text" name="video" value="{{$product->video}}">

			<label>Price (€)</label>
			<input type="text" name="price" value="{{$product->price}}">

			<label>Shipment Price (€)</label>
			<input type="text" name="shipment_price" value="{{$product->shipment_price}}">

			<label>Stock</label>
			<input type="text" name="stock" value="{{$product->stock}}">

			<label>Menu Order</label>
			<select name="menu_order">
				@foreach ($products as $key => &$value)
					<option value="{{$key}}" @if($key==$product->menu_order) selected @endif>{{$key}}</option>
				@endforeach

				@if (empty($product->id))
					<option value="{{$key++}}" selected>{{$key}}</option>
				@endif
			</select>

			<label>Visible</label>
			<select name="visible">
				<option value="0" @if(!$product->visible) selected @endif>Not Visible</option>
				<option value="1" @if($product->visible) selected @endif>Visible</option>
			</select>

			<label>Featured</label>
			<select name="featured">
				<option value="0" @if(!$product->featured) selected @endif>Not Featured</option>
				<option value="1" @if($product->featured) selected @endif>Featured</option>
			</select>

			<div class="cf"></div>

			<input type="submit" value="Save">

			@if ($product->id)
				<a class="button remove-item" href="shop/products/delete/{{$product->id}}">Delete</a>
			@endif

		</form>
	</section>

	<section>		
		@if($product->gallery)
		<section>
			@include('admin::products.gallery')
		</section>
		@endif
	</section>

@stop
