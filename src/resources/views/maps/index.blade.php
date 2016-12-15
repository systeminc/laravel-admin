@extends('admin::layouts.admin')

@section('admin-content')
	<div class="admin-header">
		<h1>Maps</h1>
		<span class="last-update"></span>
		<div class="button-wrap">
			<a href="places/maps/create" class="button right">Add Map</a>
		</div>
	</div>

	<div class="admin-content">
		@if (session('success'))
		    <span class="alert alert-success">
		        {{ session('success') }}
		    </span>
		@endif
		
		@if (!empty($maps->first()))
			<ul class="border">
				@foreach ($maps as $map)
					<li><a href="places/maps/edit/{{ $map->id }}">
							{{ ucfirst($map->title) }}</a></li>
				@endforeach
			</ul>
		@endif
	</div>
	
@stop