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
      <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
    </a>
			</li>

			<li class="sidebar-item {{ request()->is('karyawan*') ? 'active' : '' }}">
				<a class="sidebar-link" href="{{ url('/karyawan') }}">
      <i class="align-middle" data-feather="users"></i> <span class="align-middle">Karyawan</span>
    </a>
			</li>

			<li class="sidebar-item {{ request()->is('klien*') ? 'active' : '' }}">
				<a class="sidebar-link" href="{{ url('/klien') }}">
      <i class="align-middle" data-feather="user-check"></i> <span class="align-middle">Klien</span>
    </a>
			</li>

			<li class="sidebar-item {{ request()->is('stok*') ? 'active' : '' }}">
				<a class="sidebar-link" href="{{ url('/stok') }}">
      <i class="align-middle" data-feather="package"></i> <span class="align-middle">Stok Bahan</span>
    </a>
			</li>

			<li class="sidebar-item {{ request()->is('riwayat-stok*') ? 'active' : '' }}">
				<a class="sidebar-link" href="{{ url('/riwayat-stok') }}">
      <i class="align-middle" data-feather="rotate-ccw"></i> <span class="align-middle">Riwayat Stok</span>
    </a>
			</li>

			<li class="sidebar-header">
				Proyek & Keuangan
			</li>

			<li class="sidebar-item {{ request()->is('proyek*') ? 'active' : '' }}">
				<a class="sidebar-link" href="{{ url('/proyek') }}">
      <i class="align-middle" data-feather="briefcase"></i> <span class="align-middle">Manajamen Proyek</span>
    </a>
			</li>

			<li class="sidebar-item {{ request()->is('keuangan*') ? 'active' : '' }}">
				<a class="sidebar-link" href="{{ url('/keuangan') }}">
      <i class="align-middle" data-feather="dollar-sign"></i> <span class="align-middle">Kas & Keuangan</span>
    </a>
			</li>

			<li class="sidebar-item {{ request()->is('kas-rekening*') ? 'active' : '' }}">
				<a class="sidebar-link" href="{{ url('/kas-rekening') }}">
      <i class="align-middle" data-feather="credit-card"></i> <span class="align-middle">Kas Rekening Bank</span>
    </a>
			</li>

			<li class="sidebar-item {{ request()->is('hutang-piutang*') ? 'active' : '' }}">
				<a class="sidebar-link" href="{{ url('/hutang-piutang') }}">
      <i class="align-middle" data-feather="file-text"></i> <span class="align-middle">Hutang Piutang</span>
    </a>
			</li>
		</ul>
	</div>
</nav>
