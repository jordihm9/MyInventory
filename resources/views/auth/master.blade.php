<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>My Inventory</title>

	@env('production')
		<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
		<style>
			@import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap');
			@import url('https://fonts.googleapis.com/css2?family=Fira+Sans:wght@300;400;600&display=swap');
		</style>
	@endenv

	@env('local')
		<script src="{{ asset('/js/jquery-3.6.0.min.js') }}"></script>
		<link rel="stylesheet" href="{{ asset('/css/font-face.css') }}">
	@endenv
	
	@stack('scripts')
	<link rel="stylesheet" href="/css/style.css">
</head>

<body>
	<main>
		<div id="auth-container" class="container">
			<div><h1 class="underline">@yield('title')</h1></div>
			@yield('content')
		</div>
	</main>	
</body>

</html>