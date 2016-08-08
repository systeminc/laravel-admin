@extends('admin_layouts.document')

@section('styles')
	@parent
	<link rel="stylesheet" href="{{ trim(elixir('css/admin.css'), '/') }}">
@append

@section('scripts')
	@parent
	<script src="{{ trim(elixir('js/admin.js'), '/') }}"></script>
	@yield('custom-script')
@append

@section('body')

	<header class="cf">
		<div class="header-top">
			<a href="{{Request::segment(1)}}" class="logo"><img src="images/logo-white.png" alt="Load Afrika logo"></a>
		</div>

		<div class="header-menu cf">
			<ul class="cf">
				<li><a href="{{Request::segment(1)}}/pages">Pages</a></li>
			</ul>
			<ul class="account cf">
				<li><a href="{{Request::segment(1)}}/change-password">Change password</a></li>
				<li><a href="{{Request::segment(1)}}/logout">Logout</a></li>
			</ul>
		</div>
	</header>

	<script>
		$(".header-menu a").each(function(index, el) {
			if('{{Request::path()}}'.search($(this).attr('href')) != -1){
				$(this).parent().addClass('active');
			}
		});
	</script>

	<div class="admin-content cf">
		@yield('admin-content')
	</div>

@append