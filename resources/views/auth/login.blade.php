@extends('layouts.app-auth')

@section('title', 'Login')

@section('content')
<div class="row vh-100">
	<div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
		<div class="d-table-cell align-middle">

			<div class="text-center mt-4">
				<h1 class="h2">APLIKASI CV</h1>
				<p class="lead">
					Sign in to your account to continue
				</p>
			</div>

			<div class="card">
				<div class="card-body">
					<div class="m-sm-4">
						<div class="text-center">
							<img src="{{ asset('assets/img/avatars/avatar.jpg') }}" alt="Logo" class="img-fluid rounded-circle" width="132" height="132" />
						</div>
						<form action="{{ route('login') }}" method="POST">
                            @csrf

                            @if ($errors->any())
                                <div class="alert alert-danger p-2 mb-3">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

							<div class="mb-3">
								<label class="form-label">Email</label>
								<input class="form-control form-control-lg" type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required />
							</div>
							<div class="mb-3">
								<label class="form-label">Password</label>
								<input class="form-control form-control-lg" type="password" name="password" placeholder="Enter your password" required />
							</div>
							<div>
								<label class="form-check">
            <input class="form-check-input" type="checkbox" value="remember-me" name="remember-me" checked>
            <span class="form-check-label">
              Remember me next time
            </span>
          </label>
							</div>
							<div class="text-center mt-3">
								<button type="submit" class="btn btn-lg btn-primary w-100">Sign in</button>
							</div>
						</form>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
@endsection
