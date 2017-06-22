@extends('admin::layouts.admin')

@section('admin-content')

	<div class="admin-header">
		<h1>Add Variation</h1>
		<span class="last-update"></span>
	</div>

	<div class="admin-content">

		<form style="max-width: 100%;" action="shop/products/save-variation/{{ $product_id }}" class="images" method="post" enctype="multipart/form-data">
			{{ csrf_field() }}
			<div class="cf">

				@if ($errors->first('title'))
				    <div class="alert alert-error no-hide">
				        <span class="help-block">
				            <strong>{{ $errors->first('title') }}</strong>
				        </span>
				    </div>
				@endif 

				<label>Title*</label>
				<input type="text" name="title" value="{{old('title')}}">

				<label>Key</label>
				<input type="text" name="key" value="{{old('key')}}">

				<label>Content</label>
				<textarea name="content" data-page-name="variations" data-page-id="new" id="editor-new" class="htmlEditor" rows="15">{{old('content') }}</textarea>

				@if ($errors->first('group'))
				    <div class="alert alert-error no-hide">
				        <span class="help-block">
				            <strong>{{ $errors->first('group') }}</strong>
				        </span>
				    </div>
				@endif 

				<label>Group*</label>
				<input type="text" name="group" value="{{old('group')}}">

				<label>Price</label>
				<input type="text" name="price" value="{{old('price')}}">

				<label>Image</label>
				<div class="file-input-wrap cf">
					<div class="fileUpload">
						<span>Choose file</span>
						<input type="file" name="image"/>
					</div>
				</div>
			</div>
			<input type="submit" value="Add" class="save-item">
		</form>
	</div>
@endsection