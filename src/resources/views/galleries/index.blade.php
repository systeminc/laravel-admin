@extends('admin::layouts.admin')

@section('admin-content')

	<div class="admin-header">
		<h1>Galleries</h1>
		<span class="last-update"></span>
		<div class="button-wrap">
			<a href="galleries/create" class="button right">Create Gallery</a>
		</div>
	</div>

	<div class="admin-content">
		<ul class="border">
			@foreach ($galleries as $gallery)
				<li><a href="galleries/edit/{{ $gallery->id }}"><b>{{ ucfirst($gallery->title) }}</a></li>
				
			@endforeach
		</ul>
		
	</div>
	
@stop