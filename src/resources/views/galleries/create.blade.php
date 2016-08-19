@extends('admin::layouts.admin')

@section('admin-content')

	<h1>Create Gallery</h1>

	<form style="max-width: 100%;" action="galleries/save" method="post" enctype="multipart/form-data">
		{{ csrf_field() }}
		<label for="title">Title:</label>
		<input type="text" name="title" placeholder="Title">
	
	    <div class="fileUpload">
			<span>Add image</span>
			<input type="file" name="images[]" multiple="multiple">
		</div>
	</form>

<script>
	$(".fileUpload input").change(function(event) {
		if ($(this).parents('form').children('input[name=title]').val() !== "") {
			$(this).parents('form').submit();
		}
		else {
			$(this).parents('form').children('input[name=title]').css('border-color', '#900');
		}
	});
</script>
@stop