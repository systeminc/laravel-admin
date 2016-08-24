@extends('admin::layouts.admin')

@section('admin-content')

	<h1>Create code block</h1>

	<form style="max-width: 100%;" action="code-blocks/save" method="post">
		{{ csrf_field() }}

		@if ($errors->has('message'))
			<span class="alert alert-error">{{ $errors->first('message') }}</span></br>
		@endif

		<div>
			<label for="title">Title:</label>
			<input type="text" name="title" placeholder="Title">
		</div>


		<div>
			<label for="html_layout">Code:</label>
			<textarea name="html_layout" id="code"></textarea>
		</div>

		<input type="submit" value="Save">
	</form>
<script>
	var delay;
	var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
		lineNumbers: true,
		matchBrackets: true,
		mode: "application/x-httpd-php",
		indentUnit: 4,
		indentWithTabs: true
	});
</script>
@stop