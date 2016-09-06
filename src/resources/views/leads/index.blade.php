@extends('admin::layouts.admin')

@section('admin-content')

	<div>
		<a href="leads/settings" class="button right">Settings</a>
		<a href="leads/email-leads" class="button right">Email leeds</a>
		<h1>Leads</h1>
		<span class="last-update"></span>
	</div>
	
	<ul>
		@foreach ($leads as &$lead)
			<li><a href="leads/edit/{{$lead->id}}"><b>{{ $lead->data }}</a></li>
		@endforeach
	</ul>

	@if (!empty($leads))
		{{ $leads->render() }}
	@endif
@stop