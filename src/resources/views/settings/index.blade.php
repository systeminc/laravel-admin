@extends('admin::layouts.admin')

@section('admin-content')

	<div class="admin-header">
		<h1>Settings</h1>
		<span class="last-update">Last change: 06 Sep, 2016, 11:38h</span>
		<div class="button-wrap">
			<a href="settings/add-admin" class="button right">Add Admin</a>
		</div>
	</div>

	<div class="admin-content">
		<form action="settings/update" method="post" enctype="multipart/form-data">
			
			{{ csrf_field() }}

			<label>Admin panel Title</label>
			<input type="text" name="title" placeholder="Admin panel title" value="{{ @$setting->title }}">

		    <div class="fileUpload">
				<span>Change logo</span>
				<input type="file" name="logo">
			</div>
			<div class="cf"></div>

			<input type="submit" value="Save" class="save-item">
		</form>

		<div class="section-header">
			<span>Admins</span>
			<div class="line"></div>
		</div>
		<span class="last-update"></span>
		
		<ul>
			@foreach ($admins as &$admin)
				<li><a href="settings/edit/{{$admin->id}}"><b>{{$admin->name}}</a></li>
			@endforeach
		</ul>
		
		
	</div>


@stop