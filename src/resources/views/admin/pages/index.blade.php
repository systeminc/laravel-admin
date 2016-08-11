@extends('admin_layouts.admin')

@section('admin-content')

	<h1>Pages</h1>

	<a href="administration/pages/create">Create Page</a>

	<ul>
	@foreach ($pages as $page)
		<a href="administration/pages/edit/{{ str_replace(".blade", "", \File::name($page)) }}">
			<li style="padding: 20px;font-size: 20px;border-radius: 10px;">
				{{ ucfirst(str_replace(".blade", "", \File::name($page))) }}
			</li>
		</a>
	@endforeach
	</ul>
@stop