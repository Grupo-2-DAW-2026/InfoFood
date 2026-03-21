{{-- Extendemos la plantilla base para heredar el diseño general --}}
@extends('layouts.app')

{{-- Definimos el título específico para la pestaña del navegador --}}
@section('title', '- Login')

@section('content')
{{-- Centramos la tarjeta de login en la pantalla --}}
<div class="row justify-content-center">
    <div class="col-md-5">
        {{-- Tarjeta blanca sin bordes y con sombra suave --}}
        <div class="card shadow-sm border-0">
            <div class="card-body p-5">
                {{-- Título principal del formulario --}}
                <h3 class="fw-bold text-center mb-4">Acceso Usuarios</h3>

                {{-- Formulario de inicio de sesión apuntando a la ruta POST de Laravel Breeze --}}
                <form method="POST" action="{{ route('login') }}">
                    {{-- Token de seguridad obligatorio para formularios POST --}}
                    @csrf

                    {{-- Campo para el Correo Electrónico --}}
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">CORREO ELECTRÓNICO</label>
                        {{-- input con validación de error de Bootstrap y mantenimiento del valor antiguo --}}
                        <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                        {{-- Muestra el mensaje de error si el email es incorrecto --}}
                        @error('email')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Campo para la Contraseña --}}
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">CONTRASEÑA</label>
                        <input type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" required>
                        {{-- Muestra el mensaje de error si la contraseña falla --}}
                        @error('password')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Botón de envío que ocupa todo el ancho disponible --}}
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-danger btn-lg shadow-sm">
                            Entrar ahora
                        </button>
                    </div>

                    {{-- Enlace para usuarios que aún no tienen cuenta --}}
                    <div class="text-center mt-4">
                        <p class="small text-muted">¿No tienes cuenta? <a href="{{ route('register') }}" class="text-danger">Regístrate</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection