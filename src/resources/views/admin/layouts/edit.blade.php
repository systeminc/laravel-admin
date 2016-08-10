@extends('admin_layouts.admin')

@section('custom-script')
	<script src="{{ trim(elixir('js/editor.js'), '/') }}"></script>
@stop

@section('admin-content')

	<h1>Update Layout</h1>

	<form action="administration/layouts/update/{{ $filename }}" method="post">
		{{ csrf_field() }}

		@if ($errors->has('message'))
			<span>{{ $errors->first('message') }}</span>
		@endif

		<label for="title">Title:</label>
		<input type="text" name="title" placeholder="Title" value="{{ $filename }}">

		<div>
			<label>Preview:</label>
			<input type="hidden" name="image" value="{{ $template }}">
			<img style="border: 1px solid #000;" src="images/{{ $template }}">
		</div>

		<label for="html_layout">Code:</label>
		<textarea name="html_layout" id="code">{{ $snippet }}</textarea>

		<input type="submit" value="Update">
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