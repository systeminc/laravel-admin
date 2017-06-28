<div class="section-header">
	<span>Variations</span>
	<div class="line"></div>
</div>

@if (session('variation'))
    <div class="alert alert-error no-hide">
        <span class="help-block">
            <strong>{{ session('variation') }}</strong>
        </span>
    </div>
@endif

			
@if (!empty($product->variations->first()))
	
	<ul class="elements-list">
		@foreach ($product->variations as $variation)
			<li>
				<a href="shop/products/edit-variation/{{$variation->id}}"><b>{{ ucfirst($variation->title) }}</b></a>
				<a href="shop/products/delete-variation/{{ $variation->id }}" class="button remove-item file list delete">Delete</a>
			</li>
		@endforeach
	</ul>
@else
	<p>No variation yet</p>
@endif

<div class="cf">
	<a href="shop/products/add-variation/{{ $product->id }}" class="button">Add new variation</a>
</div>