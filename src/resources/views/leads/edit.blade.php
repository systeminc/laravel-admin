@extends('admin::layouts.admin')

@section('admin-content')

	<h1>Edit lead</h1>

	@foreach ($data as $key => $element)
		<label>{{ $key }}</label>
		<input type="text" name="{{ $key }}" value="{{ $element }}">

		@if (!filter_var($element, FILTER_VALIDATE_EMAIL) === false)
			<?php $email = $element; ?>
		@endif

	@endforeach
	<a href="leads/delete/{{ $lead->id }}" class="button">Delete lead</a>

	<ul>
		@foreach (SystemInc\LaravelAdmin\LeadMailed::whereEmail($email)->get() as $mailed)
			<li><a href="leads/edit-email/{{$mailed->id}}"><b>{{ $mailed->email }} :: {{ $mailed->subject }}</a></li>
		@endforeach
	</ul>

@stop