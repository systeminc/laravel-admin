@extends('admin::layouts.admin')

@section('admin-content')

	<div>
		<h1>Leads Setting</h1>
		<span class="last-update"></span>
	</div>

	@if (session('error'))
	    <span class="alert alert-error">
	        {{ session('error') }}
	    </span>
	@endif
	
	@if (session('success'))
	    <span class="alert alert-success">
	        {{ session('success') }}
	    </span>
	@endif
	
	<form action="" method="post">

	{{ csrf_field() }}

		<select name="receivers[]" multiple style="width: 100%;">
		
			@foreach ($leads as $lead)

				<?php $json = json_decode($lead->data);?>

				@if (!empty($json->email))
					<option value="{{ $json->email }}">{{ $json->email }}</option>
				@endif

			@endforeach
		</select>
	
		<label for="subject">Subject</label>
		<input type="text" name="subject" placeholder="Subject">

		<label>Email body</label>
		<textarea name="body" class="htmlEditor" rows="15" data-page-name="leads" data-page-id="2" id="editor-2"></textarea>

		<input type="submit" value="Send">
	</form>

@stop