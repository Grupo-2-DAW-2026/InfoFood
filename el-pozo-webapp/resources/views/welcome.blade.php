@extends('layouts.app')

@section("title" , "- Inicio")

@section('content')
<div class="row align-items-center" style="min-height: 60vh;">
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
        </div>
    @endif
    <div class="col-md-6 text-center text-md-start">
        <h1 class="display-4 fw-bold text-danger">Trazabilidad Digital</h1>
        <p class="lead text-secondary">Transparencia desde la granja hasta tu mesa. Conoce cada detalle de lo que consumes.</p>
        
        <div class="mt-4 d-grid d-md-block gap-2">
            <a href="{{ route('escaner') }}" class="btn btn-danger btn-lg px-5 shadow">
                <i class="bi bi-qr-code-scan"></i> ESCANEAR PRODUCTO
            </a>
            <a href="{{ route('productos.catalogo') }}" class="btn btn-danger btn-lg px-5 shadow">
                <i class="bi bi-view-catalog"></i> VER CATALOGO
            </a>
        </div>
    </div>

    <div class="col-md-5 offset-md-1 mt-5 mt-md-0">
        <div class="card shadow-lg border-0 rounded-4">
<div class="card-body p-4">
    @auth
        <h4 class="fw-bold">Bienvenido, {{ Auth::user()->name }}</h4>
        <p class="text-muted">
            Has iniciado sesión como 
            <strong>{{ Auth::user()->role == 'admin' ? 'ADMINISTRADOR' : 'USUARIO' }}</strong>.
        </p>

        <a href="{{ route('productos.crear') }}" class="btn btn-dark w-100 mb-2 shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Añadir Nuevo Producto
        </a>

        @if(Auth::user()->role == 'admin')
            <div class="alert alert-warning border-0 small">
                Tienes permisos de administrador para gestionar todo el sistema.
            </div>
        @endif      
    @else
        <h4 class="fw-bold text-center mb-4">Acceso Usuarios</h4>
        <p class="text-muted small text-center">Inicia sesión para registrar productos o consultar tu historial.</p>
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