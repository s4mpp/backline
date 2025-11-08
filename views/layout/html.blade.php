<!DOCTYPE html>
<html lang="pt-BR" class="h-full">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<meta name="robots" content="noindex, nofollow">

		@hasSection('title')
			<title>{{ config('app.name') }} | @yield('title')</title>
		@else
			<title>{{ config('app.name') }}</title>
		@endif

		<link rel="stylesheet" href="{{ asset('vendor/backline/css/style.css') }}">
		<link rel="stylesheet" href="{{ asset('vendor/backline/fonts/font-awesome/css/all.min.css') }}">
	</head>
	<body class="h-full min-h-full">
        @yield('body')

        @stack('scripts')

		<script src="{{ asset('vendor/backline/js/app.js') }}"></script>
	</body>
</html>