<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="{{ config('app.name') }} - Dashboard Manajemen Operasional">
	<meta name="author" content="Admin">
	<meta name="keywords" content="aplikasi cv, manajemen proyek, keuangan">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="{{ asset('assets/img/icons/icon-48x48.png') }}" />

	<title>@yield('title', 'Dashboard') | {{ config('app.name') }}</title>

	<link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap"
		rel="stylesheet">
	<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
	<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">

	<style>
		:root {
			--app-accent: #3b7ddd;
			--app-accent-soft: #e9f1ff;
			--app-border: #e5eaf2;
			--app-text-soft: #6b778c;
		}

		body {
			font-family: "Manrope", "Segoe UI", sans-serif;
			background-color: #f4f7fb;
		}

		.content {
			padding-top: 1.25rem;
		}

		.navbar-bg {
			position: sticky;
			top: 0;
			z-index: 1000;
			backdrop-filter: blur(4px);
			box-shadow: 0 1px 0 rgba(15, 23, 42, .06);
		}

		.navbar-company {
			display: inline-flex;
			align-items: center;
			gap: .6rem;
			margin-left: .85rem;
		}

		.navbar-company-logo {
			width: 32px;
			height: 32px;
			object-fit: cover;
			border-radius: 8px;
			border: 1px solid #d8e2f0;
			background: #fff;
		}

		.navbar-company-name {
			font-size: .9rem;
			font-weight: 700;
			color: #344258;
			max-width: 220px;
			white-space: nowrap;
			overflow: hidden;
			text-overflow: ellipsis;
		}

		.sidebar-brand {
			font-weight: 800;
			letter-spacing: .2px;
		}

		.card {
			border: 1px solid var(--app-border);
			border-radius: 14px;
			box-shadow: 0 8px 24px rgba(15, 23, 42, .04);
		}

		.card .card-header {
			border-bottom: 1px solid var(--app-border);
			background: #fff;
		}

		h1,
		h2,
		h3,
		h4,
		h5,
		h6 {
			letter-spacing: -.01em;
		}

		.text-muted {
			color: var(--app-text-soft) !important;
		}

		.btn {
			border-radius: 10px;
			font-weight: 600;
		}

		.btn-primary {
			box-shadow: 0 8px 18px rgba(59, 125, 221, .22);
		}

		.form-control,
		.form-select {
			border-radius: 10px;
			border-color: #dbe4f0;
		}

		.form-control:focus,
		.form-select:focus {
			border-color: #9fc0ef;
			box-shadow: 0 0 0 .2rem rgba(59, 125, 221, .15);
		}

		.table {
			--bs-table-striped-bg: #f9fbff;
		}

		.table>:not(caption)>*>* {
			vertical-align: middle;
		}

		.table thead th {
			font-weight: 700;
			font-size: .86rem;
			color: #5b687f;
			text-transform: uppercase;
			letter-spacing: .03em;
		}

		/* Fix DataTables inside AdminKit cards */
		.card .dataTables_wrapper {
			padding: 1rem;
		}

		.card .dataTables_wrapper .dataTables_length,
		.card .dataTables_wrapper .dataTables_filter {
			margin-bottom: 0.75rem;
		}

		.card .dataTables_wrapper .dataTables_info,
		.card .dataTables_wrapper .dataTables_paginate {
			margin-top: 0.75rem;
			padding-bottom: 0;
		}

		/* Fix pagination showing as bullet dots */
		.dataTables_wrapper .dataTables_paginate .paginate_button {
			display: inline-block !important;
			padding: 0.375rem 0.75rem !important;
			margin-left: 2px;
			border: 1px solid #d9e3f1 !important;
			border-radius: 0.25rem;
			background: #fff !important;
			color: var(--app-accent) !important;
			cursor: pointer;
			font-size: 0.875rem;
		}

		.dataTables_wrapper .dataTables_paginate .paginate_button.current,
		.dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
			background: var(--app-accent) !important;
			border-color: var(--app-accent) !important;
			color: #fff !important;
		}

		.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
			background: var(--app-accent-soft) !important;
			color: var(--app-accent) !important;
		}

		.dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
		.dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
			color: #6c757d !important;
			cursor: default;
			opacity: 0.65;
		}

		/* Fix sorting icon alignment */
		table.dataTable thead th {
			position: relative;
			padding-right: 26px !important;
		}

		/* Clean spacing */
		div.dataTables_wrapper div.dataTables_length select {
			width: auto;
			display: inline-block;
		}

		.dataTables_wrapper .dataTables_filter input {
			border-radius: 10px;
			border: 1px solid #dbe4f0;
			padding: .375rem .65rem;
		}

		@media (max-width: 767.98px) {
			.content {
				padding-top: .95rem;
			}

			.card .dataTables_wrapper {
				padding: .75rem;
			}

			div.dataTables_wrapper div.dataTables_filter {
				text-align: left;
				margin-top: .5rem;
			}

			div.dataTables_wrapper div.dataTables_filter input {
				width: 100%;
				margin-left: 0;
			}
		}
	</style>
	@stack('css')
</head>

<body>
	<div class="wrapper">
		<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="{{ url('/') }}">
					<span class="align-middle">{{ config('app.name') }}</span>
				</a>

				<ul class="sidebar-nav">
					<li class="sidebar-header">
						Main Menu
					</li>

					<li class="sidebar-item {{ request()->is('dashboard') ? 'active' : '' }}">
						<a class="sidebar-link" href="{{ url('/dashboard') }}">
							<i class="align-middle" data-feather="sliders"></i> <span
								class="align-middle">Dashboard</span>
						</a>
					</li>

					@if(auth()->user()->hasAccess(['admin', 'manajer']))
					<li class="sidebar-item {{ request()->is('karyawan*') ? 'active' : '' }}">
						<a class="sidebar-link" href="{{ url('/karyawan') }}">
							<i class="align-middle" data-feather="users"></i> <span class="align-middle">Karyawan</span>
						</a>
					</li>

					<li class="sidebar-item {{ request()->is('klien*') ? 'active' : '' }}">
						<a class="sidebar-link" href="{{ url('/klien') }}">
							<i class="align-middle" data-feather="user-check"></i> <span
								class="align-middle">Klien</span>
						</a>
					</li>

					<li class="sidebar-item {{ request()->is('stok*') ? 'active' : '' }}">
						<a class="sidebar-link" href="{{ url('/stok') }}">
							<i class="align-middle" data-feather="package"></i> <span class="align-middle">Stok
								Bahan</span>
						</a>
					</li>

					<li class="sidebar-item {{ request()->is('riwayat-stok*') ? 'active' : '' }}">
						<a class="sidebar-link" href="{{ url('/riwayat-stok') }}">
							<i class="align-middle" data-feather="rotate-ccw"></i> <span class="align-middle">Riwayat
								Stok</span>
						</a>
					</li>

					<li class="sidebar-item {{ request()->is('pembelian*') ? 'active' : '' }}">
						<a class="sidebar-link" href="{{ url('/pembelian') }}">
							<i class="align-middle" data-feather="shopping-bag"></i> <span
								class="align-middle">Pembelian Stok</span>
						</a>
					</li>

					<li class="sidebar-header">
						Proyek
					</li>

					<li class="sidebar-item {{ request()->is('proyek*') ? 'active' : '' }}">
						<a class="sidebar-link" href="{{ url('/proyek') }}">
							<i class="align-middle" data-feather="briefcase"></i> <span class="align-middle">Manajemen
								Proyek</span>
						</a>
					</li>
					@endif

					@if(auth()->user()->hasAccess(['admin', 'keuangan']))
					<li class="sidebar-header">
						Keuangan
					</li>

					<li class="sidebar-item {{ request()->is('keuangan*') ? 'active' : '' }}">
						<a class="sidebar-link" href="{{ url('/keuangan') }}">
							<i class="align-middle" data-feather="dollar-sign"></i> <span class="align-middle">Kas &
								Keuangan</span>
						</a>
					</li>

					<li class="sidebar-item {{ request()->is('kas-rekening*') ? 'active' : '' }}">
						<a class="sidebar-link" href="{{ url('/kas-rekening') }}">
							<i class="align-middle" data-feather="credit-card"></i> <span class="align-middle">Kas
								Rekening Bank</span>
						</a>
					</li>

					<li class="sidebar-item {{ request()->is('hutang-piutang*') ? 'active' : '' }}">
						<a class="sidebar-link" href="{{ url('/hutang-piutang') }}">
							<i class="align-middle" data-feather="file-text"></i> <span class="align-middle">Hutang
								Piutang</span>
						</a>
					</li>
					@endif

					@if(auth()->user()->isAdmin())
					<li class="sidebar-header">
						Pengaturan
					</li>

					<li class="sidebar-item {{ request()->is('users*') ? 'active' : '' }}">
						<a class="sidebar-link" href="{{ url('/users') }}">
							<i class="align-middle" data-feather="shield"></i> <span class="align-middle">Manajemen
								User</span>
						</a>
					</li>

					<li class="sidebar-item {{ request()->is('log-aktivitas*') ? 'active' : '' }}">
						<a class="sidebar-link" href="{{ url('/log-aktivitas') }}">
							<i class="align-middle" data-feather="activity"></i> <span class="align-middle">Log
								Aktivitas</span>
						</a>
					</li>

					<li class="sidebar-item {{ request()->is('settings*') ? 'active' : '' }}">
						<a class="sidebar-link" href="{{ url('/settings') }}">
							<i class="align-middle" data-feather="settings"></i> <span
								class="align-middle">Pengaturan</span>
						</a>
					</li>
					@endif
				</ul>
			</div>
		</nav>

		<div class="main">
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle js-sidebar-toggle">
					<i class="hamburger align-self-center"></i>
				</a>

				<a class="navbar-company" href="{{ route('dashboard') }}" aria-label="{{ config('app.name') }}">
					<img src="{{ $appSettings['logo_url'] }}" alt="Logo {{ config('app.name') }}"
						class="navbar-company-logo">
					<span class="navbar-company-name d-none d-md-inline">{{ config('app.name') }}</span>
				</a>

				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#"
								data-bs-toggle="dropdown">
								<i class="align-middle" data-feather="settings"></i>
							</a>

							<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#"
								data-bs-toggle="dropdown">
								<img src="{{ asset('assets/img/avatars/avatar.jpg') }}"
									class="avatar img-fluid rounded me-1" alt="{{ Auth::user()->name }}" /> <span
									class="text-dark">{{ Auth::user()->name }}</span>
							</a>
							<div class="dropdown-menu dropdown-menu-end">
								<a class="dropdown-item" href="{{ route('profile.index') }}"><i
										class="align-middle me-1" data-feather="user"></i> Profile</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="{{ route('settings.index') }}"><i
										class="align-middle me-1" data-feather="settings"></i> Settings & Privacy</a>
								<div class="dropdown-divider"></div>
								<form action="{{ route('logout') }}" method="POST">
									@csrf
									<button type="submit" class="dropdown-item">Log out</button>
								</form>
							</div>
						</li>
					</ul>
				</div>
			</nav>

			<main class="content">
				<div class="container-fluid p-0">
					@yield('content')
				</div>
			</main>

			<footer class="footer">
				<div class="container-fluid">
					<div class="row text-muted">
						<div class="col-6 text-start">
							<p class="mb-0">
								<strong>{{ config('app.name') }}</strong> &copy; {{ date('Y') }}
							</p>
							@if(!empty($appSettings['alamat']))
							<small class="d-block text-muted mt-1">{{ $appSettings['alamat'] }}</small>
							@endif
						</div>
						<div class="col-6 text-end">
							<ul class="list-inline">
								@if(!empty($appSettings['telepon']))
								<li class="list-inline-item">
									<a class="text-muted"
										href="tel:{{ preg_replace('/\s+/', '', $appSettings['telepon']) }}">{{
										$appSettings['telepon'] }}</a>
								</li>
								@endif
								@if(!empty($appSettings['email_cv']))
								<li class="list-inline-item">
									<a class="text-muted" href="mailto:{{ $appSettings['email_cv'] }}">{{
										$appSettings['email_cv'] }}</a>
								</li>
								@endif
							</ul>
						</div>
					</div>
				</div>
			</footer>
		</div>
	</div>

	<script src="{{ asset('assets/js/app.js') }}"></script>
	<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
	<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
	<script>
		$(document).ready(function() {
			$('.datatable').each(function() {
				if ($.fn.DataTable.isDataTable(this)) {
					return;
				}

				$(this).DataTable({
				language: {
					search: 'Cari:',
					lengthMenu: 'Tampilkan _MENU_ data',
					info: 'Menampilkan _START_ - _END_ dari _TOTAL_ data',
					infoEmpty: 'Tidak ada data',
					zeroRecords: 'Data tidak ditemukan',
					emptyTable: 'Belum ada data tersedia',
					paginate: { previous: '&laquo;', next: '&raquo;' }
				},
				pageLength: 10,
				lengthMenu: [10, 25, 50, 100],
				order: [],
				autoWidth: false,
				responsive: true,
				dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
				});
			});

		});
	</script>
	@stack('js')

</body>

</html>