@extends('layouts.app')

@section('content')
<div class="row align-items-center" style="min-height: 60vh;">
    <div class="col-md-6 text-center text-md-start">
        <img src="https://www.elpozo.com/wp-content/uploads/2021/01/logo-elpozo.png" class="img-fluid mb-4" style="max-width: 200px;">
        <h1 class="display-4 fw-bold text-danger">Trazabilidad Digital</h1>
        <p class="lead text-secondary">Transparencia desde la granja hasta tu mesa. Conoce cada detalle de lo que consumes.</p>
        
        <div class="mt-4 d-grid d-md-block gap-2">
            <a href="#" class="btn btn-danger btn-lg px-5 shadow">
                <i class="bi bi-qr-code-scan"></i> ESCANEAR PRODUCTO
            </a>
            <a href="#" class="btn btn-outline-secondary btn-lg px-4 ms-md-2">Ver Catálogo</a>
        </div>
    </div>

    <div class="col-md-5 offset-md-1 mt-5 mt-md-0">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4">
                @auth
                    <h4 class="fw-bold">Bienvenido, {{ Auth::user()->name }}</h4>
                    <p class="text-muted">Has iniciado sesión como <strong>{{ strtoupper(Auth::user()->role) }}</strong>.</p>
                    <hr>
                    @if(Auth::user()->role == 'admin')
                        <div class="alert alert-warning border-0 small">
                            Tienes permisos para gestionar el catálogo.
                        </div>
                        <a href="#" class="btn btn-dark w-100 mb-2">Añadir Nuevo Producto</a>
                    @endif
                    <a href="{{ url('/dashboard') }}" class="btn btn-outline-danger w-100">Ir al Panel de Control</a>
                @else
                    <h4 class="fw-bold text-center mb-4">Acceso Empleados</h4>
                    <p class="text-muted small text-center">Si eres gestor de calidad o admin, accede para modificar datos.</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('login') }}" class="btn btn-danger">Iniciar Sesión</a>
                        <a href="{{ route('register') }}" class="btn btn-light border text-muted">Solicitar Registro</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection