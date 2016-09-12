@extends('admin::layouts.admin')

@section('admin-content')

	<div>
		<h1>Admin panel</h1>
		<span class="last-update"></span>
	</div>	

	@if (session('error'))
	    <span class="alert alert-error">
	        {{ session('error') }}
	    </span>
	@endif
@stop