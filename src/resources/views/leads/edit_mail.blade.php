@extends('admin::layouts.admin')

@section('admin-content')

	<h1>Mail {{ $mail->subject }} for {{ $mail->email }}</h1>
	<span class="last-updated">Send: {{ $mail->updated_at->toDateTimeString() }}</span>

	{!! $mail->body !!}
@stop