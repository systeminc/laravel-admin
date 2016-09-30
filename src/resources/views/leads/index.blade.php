@extends('admin::layouts.admin')

@section('admin-content')
	
	<div class="admin-header">
		<h1>Leads</h1>
		<span class="last-update"></span>
		<div class="button-wrap">
			<a href="leads/settings" class="button right">Settings</a>
			<a href="leads/email-leads" class="button right">Email leeds</a>
		</div>
	</div>

	<div class="admin-content">

		<table class="lead-table">
			@foreach ($leads as &$lead)
				<?php $json = json_decode($lead->data);?>
				<tr onclick="document.location='leads/edit/{{$lead->id}}'" style="cursor:pointer">
					<td>{{ $lead->updated_at }}</td>
					<td>{{ $json->email }}</td>
					<td><a href="leads/delete/{{ $lead->id }}" class="button remove-item" style="margin:0">Delete lead</a></td>
				</tr>

			@endforeach
		</table>

		@if (!empty($leads))
			{{ $leads->render() }}
		@endif
		
		
	</div>

	
@stop