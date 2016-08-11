@extends('admin_layouts.admin')

@section('custom-script')
	<script src="{{ trim(elixir('js/editor.js'), '/') }}"></script>
@stop

@section('admin-content')

	<h1>Update Layout</h1>

	<form style="max-width: 100%;" class="form" action="administration/pages/update/{{ $filename }}" method="post">
		{{ csrf_field() }}

		@if ($errors->has('message'))
			<span>{{ $errors->first('message') }}</span>
		@endif

		<label for="title">Title:</label>
		<input type="text" name="title" placeholder="Title" value="{{ $filename }}">
		<input type="hidden" name="file" value="{{ $filename }}">


		<div>
			<label for="html_layout">Code:</label>
			<textarea name="html_layout" id="code">{{ $snippet }}</textarea>
		</div>

		<a href="">Preview</a>
		<input type="submit" value="Save">
	</form>
<script>
	var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
		lineNumbers: true,
		matchBrackets: true,
		mode: "application/x-httpd-php",
		indentUnit: 4,
		indentWithTabs: true
	});
</script>
@stop