@extends('admin::layouts.admin')

@section('admin-content')

	<h1>Code blocks</h1>

	<div>
		<a href="code-blocks/create" class="button button-right">Create code block</a>
	</div>
		
	<ul>
		@foreach ($code_blocks as $code_block)
			<a href="code-blocks/edit/{{ str_replace(".blade", "", \File::name($code_block)) }}">
				<li style="padding: 20px;font-size: 20px;border-radius: 10px;">
					{{ ucfirst(str_replace(".blade", "", \File::name($code_block))) }}
				</li>
			</a>
		@endforeach
	</ul>

@stop