@extends('admin::layouts.document')

@section('styles')
	@parent
	<link rel="stylesheet" type="text/css" href="css/admin.css?v={{ File::lastModified(base_path('vendor/systeminc/laravel-admin/src/resources/assets/dist/css/admin.css')) }}">
@append

@section('scripts')
	@parent
	<script src="scripts/admin.js?v={{ File::lastModified(base_path('vendor/systeminc/laravel-admin/src/resources/assets/dist/js/admin.js'))}} "></script>
	@yield('custom-script')
@append

@section('body')

	<header class="cf">
		<div class="header-top">
			<a href="" class="logo"><img src="{{ (!empty(SystemInc\LaravelAdmin\Setting::first()) && SystemInc\LaravelAdmin\Setting::first()->source !== null) ? 'uploads/'.SystemInc\LaravelAdmin\Setting::first()->source : 'images/logo-white.png' }}" alt="SystemInc Laravel admin logo"></a>
		</div>

		<div class="header-menu cf">
			<ul class="cf">
				<li><a href="blog">Blog</a>
					<ul class="submenu">
						<li><a href="blog/categories">Categories</a></li>
					</ul>
				</li>
				<li><a href="galleries">Galleries</a></li>
				<li><a href="pages">Pages</a></li>
				<li><a href="leads">Leads</a></li>
				<li><a href="locations">Locations</a></li>
				<li><a href="shop">Shop</a>
					<ul class="submenu">
						<li><a href="shop/categories">Categories</a></li>
						<li><a href="shop/products">Products</a></li>
						<li><a href="shop/comments">Products Comments</a></li>
						<li><a href="shop/orders">Orders</a></li>
						<li><a href="shop/stock">Stock</a></li>
					</ul>
				</li>
				
			</ul>
			<ul class="account cf">
				<li><a href="settings">Settings</a></li>
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