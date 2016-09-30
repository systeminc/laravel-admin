@extends('admin::layouts.admin')

@section('admin-content')

	<div class="admin-header">
		<h1>Add admin</h1>
		<span class="last-update"></span>

	</div>

	<div class="admin-content">
		@if (session('error'))
		    <span class="alert alert-error">
		        {{ session('error') }}
		    </span>
		@endif

		<form action="settings/create-admin" method="post">
			
			{{ csrf_field() }}

			<label>Admin name</label>
			<input type="text" name="name" placeholder="Admin name">

			<label>Admin email</label>
			<input type="text" name="email" placeholder="Admin email">
					
			<label>Admin Password</label>
			<input name="password" type="password">

			<input type="submit" value="Save" class="save-item">
		</form>
		
		
	</div>



@stop