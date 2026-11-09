@extends('adminlte::auth.auth-page', ['authType' => 'login'])

@section('auth_header', 'Masuk ke Portal Akademik')

@section('auth_body')
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="input-group mb-3">
            <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Email" required autofocus>
            <div class="input-group-append"><div class="input-group-text"><span class="fas fa-envelope"></span></div></div>
            @error('email') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
            <div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>
            @error('password') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
        </div>
        <div class="row align-items-center">
            <div class="col-7"><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" name="remember" id="remember"><label class="custom-control-label" for="remember">Ingat saya</label></div></div>
            <div class="col-5"><button type="submit" class="btn btn-primary btn-block">Masuk</button></div>
        </div>
    </form>

    <div class="dropdown-divider my-3"></div>
    <p class="text-sm text-muted mb-2">Login demo sekali klik</p>
    <div class="row">
        <div class="col-6">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="hidden" name="email" value="admin@kampus.test">
                <input type="hidden" name="password" value="Admin123!">
                <button type="submit" class="btn btn-outline-primary btn-block"><i class="fas fa-user-shield mr-1"></i> Admin</button>
            </form>
        </div>
        <div class="col-6">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="hidden" name="email" value="staf@kampus.test">
                <input type="hidden" name="password" value="Staf123!">
                <button type="submit" class="btn btn-outline-secondary btn-block"><i class="fas fa-user-tie mr-1"></i> Staf</button>
            </form>
        </div>
    </div>
@stop

@section('auth_footer')
    <small class="text-muted">Akun dan data demo dibuat otomatis melalui database seeder.</small>
@stop
