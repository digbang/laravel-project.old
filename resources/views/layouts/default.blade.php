<!DOCTYPE html>
<html>
<head>
	<title>@yield('title', 'New Awesome Digbang Project')</title>
	@section('metatags')
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=1" />
	@show
	@section('stylesheets')
		<link rel="stylesheet" href="{{ asset('assets/css/site.min.css') }}">
	@show
	@section('javascript-top')
		@include('modules.ie8-compat')
	@show
</head>
<body class="@yield('body_class')">
	@yield('content')

	@section('javascript-bottom')
		@if (Agent::isMobile())
            @include('modules.ie10-mobile-viewport-fix')
		@endif
		<script type="text/javascript" src="{{ asset('assets/js/site.min.js') }}"></script>
	@show
</body>
</html>