@extends('admin::layouts.admin')

@section('admin-content')
	<div class="admin-header">
		<h1>Locations</h1>
		<span class="last-update"></span>
		<div class="button-wrap">
			<a href="places/locations/create" class="button right">Add location</a>
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
				@foreach ($locations as $location)
					<li><a href="places/locations/edit/{{ $location->id }}">
							{{ ucfirst($location->title) }}</a></li>
				@endforeach
			</ul>
		@endif
	</div>
	
@stop