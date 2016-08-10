@extends('admin_layouts.admin')

@section('admin-content')

	<h1>Create Layout</h1>

	<form action="administration/pages/save" method="post">
		{{ csrf_field() }}

		@if ($errors->has('message'))
			<span>{{ $errors->first('message') }}</span>
		@endif

		<label for="title">Title:</label>
		<input type="text" name="title" placeholder="Title">

		<label for="html-layout">Layout:</label>



		<input type="submit" value="Create">
	</form>


@stop