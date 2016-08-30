@extends('admin::layouts.admin')

@section('admin-content')

	<div>
		<h1>Edit {{ $admin->name }}</h1>
		<span class="last-update"></span>
	</div>

		@if (session('error'))
		    <span class="alert alert-error">
		        {{ session('error') }}
		    </span>
		@endif

	<form action="settings/update-admin/{{ $admin->id }}" method="post">
		
		{{ csrf_field() }}

		<label>Admin name</label>
		<input type="text" name="name" placeholder="Admin name" value="{{ $admin->name }}">

		<label>Admin email</label>
		<input type="email" name="email" placeholder="Admin email" value="{{ $admin->email }}">

		<input type="submit" value="Save">
	</form>

	<h1>Change Administrator's Password</h1>
	<span class="last-update"></span>

		@if (session('success'))
		    <span class="alert alert-success">
		        {{ session('success') }}
		    </span>
		@endif

		@if (session('pass'))
		    <span class="alert alert-error">
		        {{ session('pass') }}
		    </span>
		@endif

	<form action="settings/change-password/{{ $admin->id }}" method="post">
		<input name="_token" type="hidden" value="{{csrf_token()}}">
				
		<label>Old Password</label>
		<input name="old_pass" type="password">

		<label>New Password</label>
		<input name="new_pass" type="password">

		<label>Repeat Password</label>
		<input name="confirm_pass" type="password">

		<input type="submit" value="Save">
	</form>

@stop