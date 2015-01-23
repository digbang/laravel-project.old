<!DOCTYPE html>
<html>
<head>
	<title>@yield('title', 'New Awesome Digbang Project')</title>
	@section('metatags')
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=1" />
	@show
	@section('stylesheets')
		@if(Config::get('app.debug'))
			<link rel="stylesheet/less" type="text/css" href="{{ asset('assets/css/src/site.less') }}" />
			<script type="text/javascript" src="{{ asset('assets/js/less.js') }}"></script>
		@else
			{{ HTML::style(asset('assets/css/site.min.css')) }}
		@endif
	@show
	@section('javascript-top')
		<!--[if lte IE 8]>
		<script type="text/javascript" src="{{ asset('assets/js/html5shiv.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('assets/js/respond.min.js') }}"></script>
		<![endif]-->
	@show
</head>
<body class="@yield('body_class')">
	@yield('content')

	@section('javascript-bottom')
		@if (Agent::isMobile())
		<script type="text/javascript">
			(function() {
				if ("-ms-user-select" in document.documentElement.style && navigator.userAgent.match(/IEMobile\/10\.0/)) {
					var msViewportStyle = document.createElement("style");
					msViewportStyle.appendChild(
						document.createTextNode("@-ms-viewport{width:auto!important}")
					);
					document.getElementsByTagName("head")[0].appendChild(msViewportStyle);
				}
			})();
		</script>
		@endif
		@if(Config::get('app.debug'))
			<script type="text/javascript" data-main="{{ asset('assets/js/src/site') }}" src="{{ asset('assets/js/require.js') }}"></script>
			<script type="text/javascript" src="{{ Config::get('app.url') }}:35729/livereload.js"></script>
		@else
			<script type="text/javascript" src="{{ asset('assets/js/site.min.js') }}"></script>
		@endif
	@show
</body>
</html>