<div class="section-header">
	<span>Similar products</span>
	<div class="line"></div>
</div>

@if (session('similar'))
    <div class="alert alert-error no-hide">
        <span class="help-block">
            <strong>{{ session('similar') }}</strong>
        </span>
    </div>
@endif

<form style="max-width: 100%;" action="shop/products/add-similar/{{ $product->id }}" class="images" method="post" enctype="multipart/form-data">
	{{ csrf_field() }}
	<div class="cf">
			
		@if (!empty($product->similar->first()))
			
			<ul class="elements-list">
				@foreach ($product->similar as $similar)
					<li>
						<a href="shop/products/edit/{{$similar->product_similar_id}}"><b>{{ ucfirst($similar->product->title) }}</b></a>
						<a href="shop/products/delete-similar/{{ $similar->id }}" class="button remove-item file list delete">Delete</a>
					</li>
				@endforeach
			</ul>
		@else
			<p>No similar products yet</p>
		@endif
		<label>Chose similar product</label>
		<div class="select-style">
			<select name="product_similar_id">
				@foreach ($products as $product_similar)
					@if ($product->id != $product_similar->id)
						<option value="{{ $product_similar->id }}">{{ $product_similar->title }}</option>
					@endif
				@endforeach
			</select>
		</div>
	</div>
	<input type="submit" value="Add" class="save-item">
</form>
