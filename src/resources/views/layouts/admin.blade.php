@extends('admin::layouts.document')

@section('styles')
	@parent
	<link rel="stylesheet" type="text/css" href="css/admin.css?v={{ File::lastModified(base_path('vendor/systeminc/laravel-admin/src/resources/assets/dist/css/admin.css')) }}">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
@append

@section('scripts')
	@parent
	<script src="scripts/admin.js?v={{ File::lastModified(base_path('vendor/systeminc/laravel-admin/src/resources/assets/dist/js/admin.js'))}} "></script>
	@yield('custom-script')
@append

@section('body')
	<header class="cf">
		<div class="header-top">
			<a href="" class="logo"><img src="{{ (!empty(SystemInc\LaravelAdmin\Setting::first()) && SystemInc\LaravelAdmin\Setting::first()->source != null) ? Storage::url(SystemInc\LaravelAdmin\Setting::first()->source) : 'images/logo.png' }}" alt="SystemInc Laravel admin logo"></a>
		</div>

		<div class="header-menu cf">
			<ul class="cf">
				@if (config('laravel-admin.modules.pages'))
					<li><a href="pages">Pages</a></li>
				@endif
				@if (config('laravel-admin.modules.galleries'))
					<li>
						<a href="galleries">Galleries</a>
					</li>
				@endif
				@if (config('laravel-admin.modules.blog'))
					<li {{ Request::is('blog') ? 'class="active"' : ''}}>
						<a href="blog">Blog</a>
						<div class="icon-menu"><div class="center cf"></div></div>
						<ul class="submenu">
							<li><a href="blog/categories">Categories</a></li>
						</ul>
					</li>
				@endif
				@if (config('laravel-admin.modules.places'))
					<li {{ Request::is('places') ? 'class="active"' : ''}}>
						<div class="icon-menu"><div class="center cf"></div></div>
						<a href="places">Places</a>
						<ul class="submenu">
							<li><a href="places/locations">Locations</a></li>
							<li><a href="places/maps">Maps</a></li>
						</ul>
					</li>
				@endif
				@if (config('laravel-admin.modules.leads'))
					<li><a href="leads">Leads</a></li>
				@endif
				@if (config('laravel-admin.modules.shop'))
					<li class="last">
						<div class="icon-menu"><div class="center cf"></div></div>
						<a href="shop">Shop</a>
						<ul class="submenu">
							<li><a href="shop/categories">Categories</a></li>
							<li><a href="shop/products">Products</a></li>
							<li><a href="shop/comments">Products Comments</a></li>
							<li><a href="shop/orders">Orders</a></li>
							<li><a href="shop/stock">Stock</a></li>
						</ul>
					</li>
				@endif	
			</ul>
			
			@includeIf('sla.layout.navigation')
			
			<ul class="account cf">
				@if (config('laravel-admin.modules.settings'))
					<li class="settings cf"><a href="settings">Settings</a></li>
				@endif
				<li class="logout cf"><a href="logout">Logout</a></li>
			</ul>
		</div>
	</header>

	<script>
		$(".header-menu a[href$='{{Request::segment(2)}}']").parent().addClass('active').end().siblings('.icon-menu').addClass('open');

		@if (Request::segment(3)){
			$(".header-menu a[href$='{{Request::segment(2)}}/{{Request::segment(3)}}']").parent().addClass('active');
		}
		@endif 

		$(".header-menu a[href$='{{Request::segment(2)}}-']").parent().removeClass('active');
	</script>
	
	<div class="admin-content-wrap cf">
		<div class="mobile-menu">
			<div class="container" onclick="myFunction(this)">
				<div class="bar1"></div>
				<div class="bar2"></div>
				<div class="bar3"></div>
			</div>
		</div>

		@yield('admin-content')
	</div>
@append
