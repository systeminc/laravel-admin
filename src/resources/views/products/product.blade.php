@extends('admin::layouts.admin')

@section('admin-content')

	<section>	
		<h1>{{$product->title}}</h1>
		<span class="last-update">Last change: {{ $product->updated_at->tz('CET')->format('d M Y, H:i\h') }}</span>

		<form action="shop/products/save/{{$product->id or 'new'}}" method="post" enctype="multipart/form-data">
			{{ csrf_field() }}

			@if ($errors->first('title'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('title') }}</strong>
			        </span>
			    </div>
			@endif 

			<label>Title</label>
			<input type="text" name="title" value="{{old('title') ?: $product->title}}">

			@if ($errors->first('url_id'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('url_id') }}</strong>
			        </span>
			    </div>
			@endif 

			<label>URL ID</label>
			<input type="text" name="url_id" value="{{old('url_id') ?: $product->url_id}}">

			<label>Excerpt</label>
			<textarea name="excerpt" rows="5">{{old('excerpt') ?: $product->excerpt}}</textarea>

			@if ($errors->first('description'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('description') }}</strong>
			        </span>
			    </div>
			@endif 

			<label>Description</label>
			<textarea name="description" data-page-name="product" data-page-id="{{$product->id}}" id="editor-{{ str_replace('.', '', $product->id) }}" class="htmlEditor" rows="15">{{old('description') ?: $product->description}}</textarea>

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
			<input type="text" name="animation" value="{{old('animation') ?: $product->animation}}">

			<label>Video Link</label>
			<input type="text" name="video" value="{{old('video') ?: $product->video}}">

			<label>Price (€)</label>
			<input type="text" name="price" value="{{old('price') ?: $product->price}}">

			<label>Shipment Price (€)</label>
			<input type="text" name="shipment_price" value="{{old('shipment_price') ?: $product->shipment_price}}">

			<label>Stock</label>
			<input type="text" name="stock" value="{{old('stock') ?: $product->stock}}">

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
