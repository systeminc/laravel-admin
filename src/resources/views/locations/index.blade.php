@extends('admin::layouts.admin')

@section('admin-content')
	
	@if (session('success'))
	    <span class="alert alert-success">
	        {{ session('success') }}
	    </span>
	@endif
	
	<div>
		<h1>Locations</h1>
		<a href="locations/create" class="button button-right">Add location</a>
	</div>
	
	<ul>
		@foreach ($locations as $location)
			<a href="locations/edit/{{ $location->id }}">
				<li style="padding: 20px;font-size: 20px;border-radius: 10px;">
					{{ ucfirst($location->title) }}
				</li>
			</a>
		@endforeach
	</ul>
@stop