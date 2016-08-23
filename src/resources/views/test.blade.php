@extends('admin::layouts.document')

@section('body')

@foreach ($tests as $test)
	<img src="../{{ SLA::getFile($test->thumb) }}">
	{{ $test->title }}
@endforeach

{{ SLA::shop()->first()->images }}

@stop