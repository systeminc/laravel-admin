@extends('admin_layouts.admin')

@section('custom-script')
	<script src="{{ trim(elixir('js/editor.js'), '/') }}"></script>
@stop

@section('admin-content')

	<h1>Update Layout</h1>

	<form style="max-width: 100%;" action="administration/layouts/update/{{ $filename }}" method="post">
		{{ csrf_field() }}

		@if ($errors->has('message'))
			<span>{{ $errors->first('message') }}</span>
		@endif

		<label for="title">Title:</label>
		<input type="text" name="title" placeholder="Title" value="{{ $filename }}">


		<div>
			<label for="html_layout">Code:</label>
			<textarea name="html_layout" id="code">{{ $snippet }}</textarea>
		</div>

		<div>
			<label>Preview:</label>
			<input type="hidden" name="image" value="{{ $template }}">
			<iframe id='preview' style="width: 100%;float: left;height: 300px;border: 1px solid black;border-left: 0px;"></iframe>
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
	editor.on("change", function() {
		clearTimeout(delay);
		delay = setTimeout(updatePreview, 300);
	});

	function updatePreview() {
		var previewFrame = document.getElementById('preview');
		var preview =  previewFrame.contentDocument ||  previewFrame.contentWindow.document;
		preview.open();
		preview.write(editor.getValue());
		preview.close();
	}
	setTimeout(updatePreview, 300);
</script>
@stop