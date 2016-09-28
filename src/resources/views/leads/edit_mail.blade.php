@extends('admin::layouts.admin')

@section('admin-content')
	<div class="admin-header">
		<h1>Mail {{ $mail->subject }} for {{ $mail->email }}</h1>
		<span class="last-updated">Send: {{ $mail->updated_at->toDateTimeString() }}</span>
	</div>

	<div class="admin-content">
		{!! $mail->body !!}
		
		
	</div>


@stop