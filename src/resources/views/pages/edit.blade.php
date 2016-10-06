@extends('admin::layouts.admin')

@section('admin-content')
	
	<div class="admin-header">
		<h1>Edit {{ $page->title }} page</h1>
		<span class="last-update">Last change: {{$page->updated_at->tz('CET')->format('d M, Y, H:i\h')}}</span>
	</div>

	<div class="admin-content">
		@if (session('error'))
		    <span class="alert alert-error">
		        {{ session('error') }}
		    </span>
		@endif
		
		<form action="pages/update/{{ $page->id }}" method="post">
			{{ csrf_field() }}

			@if ($errors->first('title'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('title') }}</strong>
			        </span>
			    </div>
			@endif 

			<label>Title</label>
			<input type="text" name="title" placeholder="Page title" value="{{ $page->title }}">

			@if ($errors->first('uri_key'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('uri_key') }}</strong>
			        </span>
			    </div>
			@endif 

			@if ($errors->first('elements_prefix'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('elements_prefix') }}</strong>
			        </span>
			    </div>
			@endif 

			<label>Elements Prefix</label>
			<input type="text" name="elements_prefix" placeholder="Elements Prefix" value="{{ $page->elements_prefix }}">

			<label>URI key</label>
			<input type="text" name="uri_key" placeholder="Url id" value="{{ $page->uri_key }}">

			<label>Keyword</label>
			<input type="text" name="keyword" placeholder="Keyword" value="{{ $page->keyword }}">

			@if ($errors->first('description'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('description') }}</strong>
			        </span>
			    </div>
			@endif 

			<label>Description</label>
			<textarea name="description" class="htmlEditorTools" rows="5" placeholder="Description">{{ $page->description }}</textarea>

			<div class="cf">
				<label>Parent page</label>

				<div class="select-style">
					<select name="parent_id">
						<option value="">Choose parent page</option>
					
						@foreach ($pages as $key => $parent)
							
							@if ($parent->id !== $page->id)
								<option value="{{ $parent->id }}" {{ $parent->id == $page->parent_id ? 'selected="selected"' : '' }}>{{ $parent->title }}</option>
							@endif
							
						@endforeach
					</select>
				</div>
			</div>

			<input type="submit" value="Update" class="save-item">
			<a href="pages/delete/{{ $page->id }}" class="button delete remove-item">Delete page</a>
		</form>

		<div>
		</div>

		<div class="cf">
			<div class="section-header">
				<span>Elements</span>
				<div class="line"></div>
			</div>

			@if (!empty($elements->first()))
				
				<ul class="elements-list">
					@foreach ($elements as $element)
						<li>
							<a href="pages/edit-element/{{$element->id}}"><b>{{ ucfirst($element->title) }} - {{$element->key}}</b></a>
							<a href="pages/delete-element/{{ $element->id }}" class="button remove-item file delete list">Delete</a>
						</li>
					@endforeach
				</ul>
			@else
				<p>No elements yet</p>
			@endif
			
			<form action="pages/new-element/{{ $page->id }}" method="post">
				{{ csrf_field() }}

				<div class="select-style">
					<select name="page_element_type_id" class="element-type">
						<option value="0">Add element</option>
					
						@foreach ($element_types as $element_type)
							<option value="{{ $element_type->id }}">{{ $element_type->title }}</option>
						@endforeach
					</select>
				</div>
			
			</form>
		</div>	


		<div class="cf">
			<div class="section-header">
				<span>Subpages</span>
				<div class="line"></div>
			</div>
			<div class="cf"></div>
			<a href="pages/create/{{ $page->id }}" class="button right">Add subpage</a>
			<div class="cf"></div>


			@if (!empty($page->child($page->id)))
				
				<ul class="sortable elements-list cf" data-link="ajax/{{ $page->id }}/change-subpages-order">
					@foreach ($page->child($page->id) as $key => $child)
						<li class="items-order" data-id="{{$child['id']}}">
							<a href="pages/edit/{{$child['id']}}"><b>{{ ucfirst($child['title']) }} - {{$child['uri_key']}}</a>
							<a href="pages/delete/{{ $child['id'] }}" class="button remove-item file delete list">Delete</a>
						</li>
					@endforeach
				</ul>
			@else
				<p>No subpages</p>
			@endif
		</div>	

		
		<script>
			$("body").delegate('.element-type', 'change',function(){

				if ($(this).val() == 0) {
					return false;
				}
				else {
					$(this).closest("form").submit();
				}

			});

		</script>
		
		
	</div>


@stop