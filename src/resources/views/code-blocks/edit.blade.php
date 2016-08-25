@extends('admin::layouts.admin')

@section('admin-content')

	<h1>Update code blocks</h1>

	<form style="max-width: 100%;" action="code-blocks/update/{{ $template_name }}" method="post">
		{{ csrf_field() }}

		@if ($errors->has('message'))
			<span>{{ $errors->first('message') }}</span>
		@endif

		<label for="title">Title:</label>
		<input type="text" name="title" placeholder="Title" value="{{ $template_name }}">


		<div>
			<label for="html_layout">Code:</label>
			<textarea name="html_layout" id="code">{{ $snippet }}</textarea>
		</div>

		<input type="submit" value="Save">
	</form>
	<div>
		<a class="button right" href="code-blocks/delete/{{ $template_name }}">Delete code-block</a>
	</div>
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