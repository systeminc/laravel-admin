@extends('admin::layouts.admin')

@section('admin-content')
	<div class="admin-header">
		<h1>Leads Setting</h1>
		<span class="last-update">Last change: {{ $setting->updated_at->tz('CET')->format('d M Y, H:i\h') }}</span>
	</div>

	<div class="admin-content">
		
		<form action="" method="post">

		{{ csrf_field() }}
		
			<label>Mailer name</label>
			<input type="text" name="mailer_name" value="{{ $setting->mailer_name or "" }}" placeholder="Mailer name">

			<label>Thank you subject</label>
			<input type="text" name="thank_you_subject" value="{{ $setting->thank_you_subject or "" }}" placeholder="Thank you subject">

			<label>Thank you body</label>
			<textarea placeholder="Thank you body" name="thank_you_body" class="htmlEditor" rows="15" data-page-name="leads" data-page-id="1" id="editor-1">{{ $setting->thank_you_body or "" }}</textarea>

			<input type="submit" value="Save" class="save-item">
		</form>
		
		
	</div>

	

@stop