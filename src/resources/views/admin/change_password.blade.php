@extends('admin_layouts.admin')

@section('admin-content')

	<h1>Change Administrator's Password</h1>
	<span class="last-update"></span>

	<section>
		<form action="" method="post">
			<input name="_token" type="hidden" value="{{csrf_token()}}">
					
			<label>Old Password</label>
			<input name="old_pass" type="password">

			<label>New Password</label>
			<input name="new_pass" type="password">

			<label>Repeat Password</label>
			<input name="confirm_pass" type="password">

			<input type="submit" value="Save">
		</form>
	</section>

@stop