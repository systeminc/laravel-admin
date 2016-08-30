@extends('admin::layouts.admin')

@section('admin-content')

	<div>
		<a href="settings/add-admin" class="button right">Add Admin</a>
		<h1>Settings</h1>

		<span class="last-update"></span>
	</div>

	<form action="settings/update" method="post" enctype="multipart/form-data">
		
		{{ csrf_field() }}

		<label>Admin panel Title</label>
		<input type="text" name="title" placeholder="Admin panel title" value="{{ @$setting->title }}">

	    <div class="fileUpload">
			<span>Change logo</span>
			<input type="file" name="logo">
		</div>

		<input type="submit" value="Save">
	</form>

	<h1>Admins</h1>
	<span class="last-update"></span>
	
	<ul>
		@foreach ($admins as &$admin)
			<li><a href="settings/edit/{{$admin->id}}"><b>{{$admin->name}}</a></li>
		@endforeach
	</ul>

@stop