@extends('layouts.app')

@section('title', '- Registro')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body p-5">
                <h3 class="fw-bold text-center mb-4">Nuevo Usuario</h3>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">NOMBRE COMPLETO</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">CORREO ELECTRÓNICO</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                        @error('email')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">CONTRASEÑA</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted small fw-bold">REPETIR CONTRASEÑA</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-danger btn-lg shadow-sm">
                            Crear cuenta
                        </button>
                    </div>

                    <div class="text-center mt-4">
                        <p class="small text-muted">¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-danger">Inicia sesión</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection