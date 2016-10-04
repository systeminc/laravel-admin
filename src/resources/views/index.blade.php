@extends('admin::layouts.admin')

@section('admin-content')
	<div class="admin-header">
		<h1>Admin panel</h1>
		<span class="last-update"></span>
	</div>

	<div class="admin-content">
		
		@if (session('error'))
	        <div class="alert alert-error no-hide">
	            <span class="help-block">
	                <strong>{{ session('error') }}</strong>
	            </span>
	        </div>
	    @endif
	    
	</div>
    
@stop