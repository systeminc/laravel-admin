@extends('admin::layouts.admin')

@section('admin-content')

	<div class="admin-header">
		<h1>Pages</h1>
		<span class="last-update"></span>
		<div class="button-wrap">
			<a href="pages/create" class="button right">Create page</a>
		</div>
	</div>

	<div class="admin-content">
		<ul class="border">
			@foreach ($pages as &$page)
				<li><a href="pages/edit/{{$page->id}}" {{ empty($page->parent_id) ?: "class='subpage'"}}><b>{{$page->title}}</a></li>
			@endforeach
		</ul>
	</div>
	

@stop