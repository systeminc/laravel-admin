@extends('admin::layouts.admin')

@section('admin-content')

	<div class="admin-header">
		<h1>Edit {{ $admin->name }}</h1>
		<span class="last-update">Last change: 06 Sep, 2016, 11:38h</span>
		<div class="button-wrap">
			<a href="settings/add-admin" class="button right">Add Admin</a>
		</div>
	</div>

	<div class="admin-content">
	
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
			<input type="text" name="email" placeholder="Admin email" value="{{ $admin->email }}">

			<input type="submit" value="Save" class="save-item">
		</form>
		<br>
		<div class="section-header">
			<span>Change Administrator's Password</span>
			<div class="line"></div>
		</div>
		<br><br>
		<div class="cf"></div>

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

			<input type="submit" value="Save" class="save-item">
		</form>
		
	</div>


@stop