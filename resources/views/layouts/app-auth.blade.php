<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="{{ config('app.name') }} - Manajemen Karyawan, Proyek, dan Keuangan">
	<meta name="author" content="Admin">
	<meta name="keywords" content="aplikasi cv, manajemen proyek, keuangan">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="{{ asset('assets/img/icons/icon-48x48.png') }}" />

	<title>@yield('title', 'Authentication') | {{ config('app.name') }}</title>

	<link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet">
	@stack('styles')
</head>

<body>
	<main class="d-flex w-100 min-vh-100">
		<div class="container-fluid p-0 d-flex flex-column">
			@yield('content')
		</div>
	</main>

	<script src="{{ asset('assets/js/app.js') }}"></script>

</body>

</html>