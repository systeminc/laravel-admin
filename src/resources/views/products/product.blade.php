@extends('admin::layouts.admin')

@section('admin-content')

	<div class="admin-header">
		<h1>{{$product->title}}</h1>
		<span class="last-update">Last change: {{ $product->updated_at->tz('CET')->format('d M Y, H:i\h') }}</span>
	</div>

	<div class="admin-content">
		<section>	

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

				@if ($errors->first('slug'))
				    <div class="alert alert-error no-hide">
				        <span class="help-block">
				            <strong>{{ $errors->first('slug') }}</strong>
				        </span>
				    </div>
				@endif 

				<label>Slug</label>
				<input type="text" name="slug" value="{{old('slug') ?: $product->slug}}">

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

				<label>Long Description</label>
				<textarea name="long_description" data-page-name="product_long" data-page-id="{{$product->id}}" id="editor-{{ str_replace('.', '', $product->id) }}" class="htmlEditor" rows="15">{{old('long_description') ?: $product->long_description}}</textarea>

				<div class="cf">
					<label>Product Category</label>
					<div class="select-style">
						<select name="product_category_id">
							@foreach ($categories as &$category)
								<option value="{{$category->id}}" @if($category->id==$product->product_category_id) selected @endif>{{$category->title}}</option>
							@endforeach
						</select>
					</div>
				</div>

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
				<br>

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

				<div class="cf">
					<label>Menu Order</label>
					<div class="select-style">
						<select name="menu_order">
							@foreach ($products as $key => &$value)
								<option value="{{$key}}" @if($key==$product->menu_order) selected @endif>{{$key}}</option>
							@endforeach
						
							@if (empty($product->id))
								<option value="{{$key++}}" selected>{{$key}}</option>
							@endif
						</select>
					</div>
				</div>

				<div class="cf">
					<label>Visible</label>
					<div class="select-style">
						<select name="visible">
							<option value="0" @if(!$product->visible) selected @endif>Not Visible</option>
							<option value="1" @if($product->visible) selected @endif>Visible</option>
						</select>
						
					</div>
				</div>

				<div class="cf">
					<label>Featured</label>
					<div class="select-style">
						<select name="featured">
							<option value="0" @if(!$product->featured) selected @endif>Not Featured</option>
							<option value="1" @if($product->featured) selected @endif>Featured</option>
						</select>
						
					</div>
				</div>

				<div class="cf"></div>

				<input type="submit" value="Save" class="save-item">

				@if ($product->id)
					<a class="button remove-item" href="shop/products/delete/{{$product->id}}">Delete</a>
				@endif
				<a href="{{ url()->previous() }}" class="button back-button">Back</a>

			</form>
		</section>

		<section>
			<section>
				@include('admin::products.similar')
			</section>
		</section>

		<section>
			@if($product->gallery)
			<section>
				@include('admin::products.gallery')
			</section>
			@endif
		</section>
		
	</div>


@stop
