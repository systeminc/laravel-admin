@extends('admin::layouts.document')

@section('body')
	<p>Dear Sir,</p>

	<p>In attachment You will find the {{$type == 'proforma' ? 'proforma' : ''}} invoice with payment instructions.	If You have any questions, feel free to contact us.</p>

	<p>Thank You very much.</p>
@append