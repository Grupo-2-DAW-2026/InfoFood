@extends('layouts.app')

@section('title', '- Login')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm border-0">
            <div class="card-body p-5">
                <h3 class="fw-bold text-center mb-4">Acceso Usuarios</h3>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">CORREO ELECTRÓNICO</label>
                        <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">CONTRASEÑA</label>
                        <input type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" required>
                        @error('password')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label small text-muted" for="remember">Recordar mi sesión</label>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-danger btn-lg shadow-sm">
                            Entrar ahora
                        </button>
                    </div>

                    <div class="text-center mt-4">
                        <p class="small text-muted">¿No tienes cuenta? <a href="{{ route('register') }}" class="text-danger">Regístrate</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection