@extends('admin::layouts.admin')

@section('admin-content')
	<div class="admin-header">
		<h1>Locations</h1>
		<span class="last-update"></span>
		<div class="button-wrap">
			<a href="locations/create" class="button right">Add location</a>
		</div>
	</div>

	<div class="admin-content">
		@if (session('success'))
		    <span class="alert alert-success">
		        {{ session('success') }}
		    </span>
		@endif

		<ul class="border">
			@foreach ($locations as $location)
					<li><a href="locations/edit/{{ $location->id }}">
						{{ ucfirst($location->title) }}</a></li>
			@endforeach
		</ul>
	</div>
	
@stop