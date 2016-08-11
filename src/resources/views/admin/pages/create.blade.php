@extends('admin_layouts.admin')

@section('admin-content')

	<h1>Create Page</h1>

	<form action="administration/pages/save" method="post">
		{{ csrf_field() }}

		@if ($errors->has('message'))
			<span>{{ $errors->first('message') }}</span>
		@endif

		<label for="title">Title:</label>
		<input type="text" name="title" placeholder="Title">

		<select style="width: 100%" name="template">
			@foreach ($templates as $key => $template)
				<option value="{{ File::name($template) }}">{{ File::name($template) }}</option>
			@endforeach
		</select>

		<input type="submit" value="Create">
	</form>

@stop