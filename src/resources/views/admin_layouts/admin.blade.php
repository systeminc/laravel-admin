@extends('admin_layouts.document')

@section('styles')
	@parent
	<link rel="stylesheet" href="{{ trim(elixir('css/admin.css'), '/') }}">
	<link rel="stylesheet" href="{{ trim(elixir('css/codemirror.css'), '/') }}">
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
				<li><a href="{{Request::segment(1)}}/blog">Blog</a></li>
				<li><a href="{{Request::segment(1)}}/blog-comments">Blog Comments</a></li>
				<li><a href="{{Request::segment(1)}}/categories">Categories</a></li>
				<li><a href="{{Request::segment(1)}}/code-blocks">Code blocks</a></li>
				<li><a href="{{Request::segment(1)}}/galleries">Galleries</a></li>
				<li><a href="{{Request::segment(1)}}/orders">Orders</a></li>
				<li><a href="{{Request::segment(1)}}/pages">Pages</a></li>
				<li><a href="{{Request::segment(1)}}/products">Products</a></li>
				<li><a href="{{Request::segment(1)}}/products-comments">Products Comments</a></li>
				<li><a href="{{Request::segment(1)}}/stock">Stock</a></li>
			</ul>
			<ul class="account cf">
				<li><a href="{{Request::segment(1)}}/change-password">Change password</a></li>
				<li><a href="{{Request::segment(1)}}/logout">Logout</a></li>
			</ul>
		</div>
	</header>

	<script>
		$(".header-menu a[href^='{{Request::path()}}']").parent().addClass('active');
		$(".header-menu a[href^='{{Request::path()}}-']").parent().removeClass('active');
	</script>
	
	<div class="admin-content cf">
		@yield('admin-content')
	</div>

@append