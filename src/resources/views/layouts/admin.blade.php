@extends('admin::layouts.document')

@section('styles')
	@parent
	<link rel="stylesheet" type="text/css" href="css/admin.css">
@append

@section('scripts')
	@parent
	<script src="scripts/admin.js"></script>
	@yield('custom-script')
@append

@section('body')

	<header class="cf">
		<div class="header-top">
			<a href="" class="logo"><img src="images/logo-white.png" alt="Load Afrika logo"></a>
		</div>

		<div class="header-menu cf">
			<ul class="cf">
				<li><a href="blog">Blog</a></li>
				<li><a href="blog/comments">Blog Comments</a></li>
				<li><a href="code-blocks">Code blocks</a></li>
				<li><a href="galleries">Galleries</a></li>
				<li><a href="pages">Pages</a></li>
				<li><a href="shop/categories">Categories</a></li>
				<li><a href="shop/products">Products</a></li>
				<li><a href="shop/comments">Products Comments</a></li>
				<li><a href="shop/orders">Orders</a></li>
				<li><a href="shop/stock">Stock</a></li>
			</ul>
			<ul class="account cf">
				<li><a href="change-password">Change password</a></li>
				<li><a href="logout">Logout</a></li>
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