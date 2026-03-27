@extends('layouts.app-auth')

@section('title', 'Login')

@push('styles')
<style>
	:root {
		--brand-900: #123b72;
		--brand-700: #2a64b0;
		--brand-500: #4d89d8;
		--cyan-400: #7bc0e8;
		--ink-900: #0f172a;
		--ink-700: #334155;
		--ink-500: #64748b;
		--surface: #ffffff;
		--surface-soft: #f5f8fc;
		--line: #d9e2ef;
	}

	body {
		font-family: "Segoe UI", "Helvetica Neue", sans-serif;
	}

	.auth-shell {
		min-height: 100vh;
		padding: 1.5rem;
		display: flex;
		align-items: center;
		justify-content: center;
		background:
			radial-gradient(1000px 520px at 8% 2%, rgba(77, 137, 216, .15), transparent 60%),
			radial-gradient(900px 460px at 95% 95%, rgba(123, 192, 232, .14), transparent 65%),
			linear-gradient(160deg, #f1f5fb 0%, #f3f7fc 45%, #f8fbfe 100%);
	}

	.auth-frame {
		width: 100%;
		max-width: 1180px;
		display: grid;
		grid-template-columns: 1.08fr .92fr;
		border-radius: 26px;
		overflow: hidden;
		box-shadow: 0 18px 48px rgba(18, 59, 114, .15);
		background: var(--surface);
	}

	.auth-hero {
		position: relative;
		padding: 3rem;
		color: #fff;
		background:
			radial-gradient(circle at 75% 20%, rgba(123, 192, 232, .22), transparent 35%),
			linear-gradient(150deg, var(--brand-900) 0%, var(--brand-700) 52%, var(--brand-500) 100%);
	}

	.auth-hero::before,
	.auth-hero::after {
		content: "";
		position: absolute;
		border-radius: 999px;
		pointer-events: none;
	}

	.auth-hero::before {
		width: 220px;
		height: 220px;
		right: -70px;
		top: -60px;
		background: rgba(255, 255, 255, .12);
	}

	.auth-hero::after {
		width: 260px;
		height: 260px;
		left: -95px;
		bottom: -120px;
		background: rgba(255, 255, 255, .09);
	}

	.auth-hero-content {
		position: relative;
		z-index: 1;
		display: flex;
		flex-direction: column;
		height: 100%;
	}

	.auth-badge {
		display: inline-flex;
		align-items: center;
		padding: .45rem .8rem;
		border-radius: 999px;
		background: rgba(255, 255, 255, .16);
		backdrop-filter: blur(4px);
		font-size: .78rem;
		font-weight: 700;
		letter-spacing: .4px;
		text-transform: uppercase;
		margin-bottom: 1.25rem;
	}

	.auth-brand {
		font-size: clamp(2rem, 2.6vw, 2.9rem);
		line-height: 1.05;
		font-weight: 800;
		margin: 0 0 1rem;
	}

	.auth-tagline {
		font-size: 1.03rem;
		line-height: 1.75;
		opacity: .95;
		max-width: 43ch;
		margin-bottom: 2rem;
	}

	.auth-points {
		list-style: none;
		padding: 0;
		margin: 0;
		display: grid;
		gap: .85rem;
	}

	.auth-points li {
		display: grid;
		grid-template-columns: 28px 1fr;
		gap: .7rem;
		align-items: center;
		font-size: .95rem;
	}

	.auth-points li::before {
		content: "";
		display: inline-block;
		width: 28px;
		height: 28px;
		border-radius: 8px;
		background:
			linear-gradient(145deg, rgba(255, 255, 255, .33), rgba(255, 255, 255, .12));
		box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .18);
	}

	.auth-panel {
		padding: 2.35rem;
		background: var(--surface);
		display: flex;
		align-items: center;
	}

	.auth-card {
		width: 100%;
		max-width: 440px;
		margin: 0 auto;
	}

	.auth-logo {
		width: 88px;
		height: 88px;
		object-fit: cover;
		border-radius: 20px;
		border: 1px solid var(--line);
		background: #fff;
		box-shadow: 0 10px 24px rgba(2, 43, 102, .14);
	}

	.auth-title {
		margin: 1rem 0 .35rem;
		font-size: 1.72rem;
		line-height: 1.15;
		font-weight: 800;
		color: var(--ink-900);
	}

	.auth-subtitle {
		color: var(--ink-500);
		font-size: .98rem;
		margin-bottom: 1.5rem;
	}

	.auth-alert {
		border-radius: 12px;
		font-size: .9rem;
	}

	.auth-label {
		display: inline-block;
		font-weight: 700;
		font-size: .88rem;
		color: var(--ink-700);
		margin-bottom: .4rem;
	}

	.auth-input {
		height: 50px;
		border-radius: 12px;
		border: 1px solid var(--line);
		background: var(--surface-soft);
		color: var(--ink-900);
	}

	.auth-input::placeholder {
		color: #8ea5c8;
	}

	.auth-input:focus {
		border-color: #6ca7ff;
		background: #fff;
		box-shadow: 0 0 0 .25rem rgba(25, 118, 255, .16);
	}

	.password-wrap {
		position: relative;
	}

	.password-wrap .auth-input {
		padding-right: 86px;
	}

	.password-toggle {
		position: absolute;
		right: .5rem;
		top: 50%;
		transform: translateY(-50%);
		height: 36px;
		padding: 0 .85rem;
		border-radius: 10px;
		border: 1px solid #cfdced;
		background: #edf3fa;
		color: #325f9b;
		font-size: .78rem;
		font-weight: 700;
		line-height: 1;
	}

	.password-toggle:hover {
		background: #e3ebf5;
	}

	.auth-meta {
		display: flex;
		justify-content: space-between;
		align-items: center;
		gap: 1rem;
		margin-top: .35rem;
	}

	.auth-meta .form-check-label {
		font-size: .92rem;
		color: var(--ink-700);
	}

	.auth-link {
		font-size: .9rem;
		font-weight: 700;
		color: #2a5f9d;
		text-decoration: none;
	}

	.auth-link:hover {
		text-decoration: underline;
	}

	.auth-submit {
		height: 50px;
		border: 0;
		border-radius: 12px;
		font-size: .95rem;
		font-weight: 700;
		letter-spacing: .2px;
		background: linear-gradient(125deg, #2f67b3 0%, #3e7cc9 65%, #66a7d3 100%);
		box-shadow: 0 10px 20px rgba(47, 103, 179, .24);
	}

	.auth-submit:hover {
		filter: brightness(.98);
	}

	@media (max-width: 1080px) {
		.auth-frame {
			grid-template-columns: 1fr;
			max-width: 650px;
		}

		.auth-hero {
			padding: 2.2rem 2rem;
		}

		.auth-panel {
			padding: 2rem 1.6rem 2.2rem;
		}
	}

	@media (max-width: 767.98px) {
		.auth-shell {
			padding: .75rem;
		}

		.auth-hero {
			padding: .9rem .95rem;
		}

		.auth-hero::before,
		.auth-hero::after {
			display: none;
		}

		.auth-panel {
			padding: 1.2rem .95rem 1.4rem;
		}

		.auth-brand {
			font-size: 1.35rem;
			margin-bottom: 0;
		}

		.auth-badge {
			font-size: .68rem;
			padding: .3rem .55rem;
			margin-bottom: .45rem;
		}

		.auth-tagline {
			display: none;
		}

		.auth-points {
			display: none;
		}

		.auth-meta {
			flex-direction: column;
			align-items: flex-start;
		}
	}
</style>
@endpush

@section('content')
<div class="auth-shell">
	<div class="auth-frame">
		<section class="auth-hero">
			<div class="auth-hero-content">
				<span class="auth-badge">Bold Corporate</span>
				<h1 class="auth-brand">{{ config('app.name') }}</h1>
				<p class="auth-tagline">
					Satu platform operasional untuk mengelola karyawan, proyek, persediaan, dan arus keuangan dengan
					lebih cepat dan akurat.
				</p>
				<ul class="auth-points">
					<li>Kontrol proyek dari planning sampai delivery</li>
					<li>Rekap kas, hutang, dan piutang dalam satu alur</li>
					<li>Audit aktivitas untuk monitoring tim real-time</li>
				</ul>
			</div>
		</section>

		<section class="auth-panel">
			<div class="auth-card">
				<div class="text-center mb-4">
					<img src="{{ asset('assets/img/avatars/avatar.jpg') }}" alt="Logo" class="auth-logo" />
					<h2 class="auth-title">Masuk ke Akun</h2>
					<p class="auth-subtitle mb-0">Silakan login untuk lanjut ke dashboard.</p>
				</div>

				@if (session('status'))
				<div class="alert alert-success auth-alert p-2 mb-3" role="alert">
					{{ session('status') }}
				</div>
				@endif

				@if ($errors->any())
				<div class="alert alert-danger auth-alert p-2 mb-3" role="alert">
					<strong>Login belum berhasil.</strong> Periksa data berikut:
					<ul class="mb-0 ps-3 mt-1">
						@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
				@endif

				<form action="{{ route('login') }}" method="POST" novalidate>
					@csrf

					<div class="mb-3">
						<label class="auth-label" for="email">Email</label>
						<input id="email" class="form-control auth-input @error('email') is-invalid @enderror"
							type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email"
							autocomplete="email" autofocus required />
						@error('email')
						<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					<div class="mb-3">
						<label class="auth-label" for="password">Password</label>
						<div class="password-wrap">
							<input id="password" class="form-control auth-input @error('password') is-invalid @enderror"
								type="password" name="password" placeholder="Masukkan password"
								autocomplete="current-password" required />
							<button type="button" class="password-toggle" id="togglePassword"
								aria-label="Tampilkan password">SHOW</button>
							@error('password')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>

					<div class="auth-meta">
						<label class="form-check m-0">
							<input class="form-check-input" type="checkbox" name="remember" {{ old('remember')
								? 'checked' : '' }}>
							<span class="form-check-label">Ingat saya</span>
						</label>

						@if (Route::has('password.request'))
						<a class="auth-link" href="{{ route('password.request') }}">Lupa password?</a>
						@endif
					</div>

					<div class="d-grid mt-3">
						<button type="submit" class="btn btn-primary auth-submit">Sign in</button>
					</div>
				</form>
			</div>
		</section>
	</div>
</div>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		const passwordInput = document.getElementById('password');
		const toggleBtn = document.getElementById('togglePassword');

		if (!passwordInput || !toggleBtn) return;

		toggleBtn.addEventListener('click', function() {
			const isPassword = passwordInput.getAttribute('type') === 'password';
			passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
			toggleBtn.textContent = isPassword ? 'HIDE' : 'SHOW';
			toggleBtn.setAttribute('aria-label', isPassword ? 'Sembunyikan password' : 'Tampilkan password');
		});
	});
</script>
@endsection