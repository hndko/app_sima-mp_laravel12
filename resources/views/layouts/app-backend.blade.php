<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="APLIKASI CV - Dashboard">
	<meta name="author" content="Admin">
	<meta name="keywords" content="aplikasi cv, manajemen proyek, keuangan">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="{{ asset('assets/img/icons/icon-48x48.png') }}" />

	<title>@yield('title', 'Dashboard') | APLIKASI CV</title>

	<link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">

	<style>
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
			border: 1px solid #dee2e6 !important;
			border-radius: 0.25rem;
			background: #fff !important;
			color: #3b7ddd !important;
			cursor: pointer;
			font-size: 0.875rem;
		}
		.dataTables_wrapper .dataTables_paginate .paginate_button.current,
		.dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
			background: #3b7ddd !important;
			border-color: #3b7ddd !important;
			color: #fff !important;
		}
		.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
			background: #e9ecef !important;
			color: #3b7ddd !important;
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
	</style>
    @stack('css')
</head>

<body>
	<div class="wrapper">
		@include('layouts.sidebar')

		<div class="main">
			@include('layouts.navbar')

			<main class="content">
				<div class="container-fluid p-0">
                    @yield('content')
				</div>
			</main>

			@include('layouts.footer')
		</div>
	</div>

	<script src="{{ asset('assets/js/app.js') }}"></script>
	<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
	<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
	<script>
		$(document).ready(function() {
			$('.datatable').DataTable({
				language: {
					search: 'Cari:',
					lengthMenu: 'Tampilkan _MENU_ data',
					info: 'Menampilkan _START_ - _END_ dari _TOTAL_ data',
					infoEmpty: 'Tidak ada data',
					zeroRecords: 'Data tidak ditemukan',
					paginate: { previous: '&laquo;', next: '&raquo;' }
				},
				pageLength: 10,
				order: [],
				dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
			});
		});
	</script>
    @stack('js')

</body>

</html>
