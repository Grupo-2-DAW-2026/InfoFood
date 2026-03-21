{{-- Directiva para extender la plantilla maestra que contiene el HEAD y el FOOTER --}}
@extends('layouts.app') 

{{-- Insertamos el título dinámico en el stack definido en el layout --}}
@section("title" , "- Inicio") 

@section('content')
{{-- Contenedor principal con Flexbox para centrar elementos verticalmente en pantallas grandes --}}
<div class="row align-items-center" style="min-height: 60vh;">
    
    {{-- LÓGICA DE ALERTAS: Verifica si existe un mensaje de error en la sesión --}}
    @if(session('error'))
        {{-- alert-dismissible: permite cerrar la alerta; shadow-sm: sombra sutil --}}
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{-- Icono de advertencia de Bootstrap Icons --}}
            {{ session('error') }} {{-- Imprime el texto del error enviado desde el controlador --}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- BLOQUE IZQUIERDO: Marketing y Acceso rápido --}}
    {{-- col-md-6: ocupa la mitad en PC; text-md-start: alinea a la izquierda en PC, centrado en móvil --}}
    <div class="col-md-6 text-center text-md-start">
        <h1 class="display-4 fw-bold text-danger">Trazabilidad Digital</h1> {{-- display-4: tamaño de fuente extra grande --}}
        <p class="lead text-secondary">Transparencia desde la granja hasta tu mesa. Conoce cada detalle de lo que consumes.</p>
        
        {{-- mt-4: margen superior; d-grid: botones en bloque para móvil; d-md-block: vuelven a su tamaño en PC --}}
        <div class="mt-4 d-grid d-md-block gap-2"> 
            {{-- Botón principal que redirige a la vista del escáner QR/EAN --}}
            <a href="{{ route('escaner') }}" class="btn btn-danger btn-lg px-5 shadow">
                <i class="bi bi-qr-code-scan"></i> ESCANEAR PRODUCTO
            </a>
            {{-- Botón secundario para navegar por la base de datos de productos --}}
            <a href="{{ route('productos.catalogo') }}" class="btn btn-danger btn-lg px-5 shadow">
                <i class="bi bi-view-catalog"></i> VER CATÁLOGO
            </a>
        </div>
    </div>

    {{-- BLOQUE DERECHO: Gestión de Sesión (Login/User Card) --}}
    {{-- offset-md-1: añade una columna de espacio en blanco para separar los bloques en PC --}}
    <div class="col-md-5 offset-md-1 mt-5 mt-md-0">
        <div class="card shadow-lg border-0 rounded-4"> {{-- rounded-4: bordes muy redondeados para diseño moderno --}}
            <div class="card-body p-4"> {{-- p-4: padding interno de nivel 4 --}}
                
                {{-- @auth: Solo se muestra si el usuario ha iniciado sesión --}}
                @auth 
                    <h4 class="fw-bold">Bienvenido, {{ Auth::user()->name }}</h4> {{-- Accedemos al nombre del usuario autenticado --}}
                    <p class="text-muted">
                        Has iniciado sesión como 
                        {{-- Badge (etiqueta): fondo oscuro para admin, se visualiza dinámicamente según el campo 'role' --}}
                        <span class="badge bg-dark">{{ Auth::user()->role == 'admin' ? 'ADMINISTRADOR' : 'USUARIO' }}</span>
                    </p>

                    {{-- Acceso directo a la creación de productos (solo usuarios registrados) --}}
                    <a href="{{ route('productos.crear') }}" class="btn btn-dark w-100 mb-2 shadow-sm">
                        <i class="bi bi-plus-circle me-1"></i> Añadir Nuevo Producto
                    </a>

                    {{-- Alerta informativa solo visible para administradores --}}
                    @if(Auth::user()->role == 'admin')
                        <div class="alert alert-warning border-0 small mt-2">
                            <i class="bi bi-shield-check"></i> Modo administrador activado.
                        </div>
                    @endif      

                {{-- @else: Se muestra a invitados (usuarios no logueados) --}}
                @else 
                    <h4 class="fw-bold text-center mb-4">Acceso Usuarios</h4>
                    <p class="text-muted small text-center">Inicia sesión para registrar productos o consultar tu historial.</p>
                    <div class="d-grid gap-2">
                        {{-- Redirección a las rutas de Breeze para login y registro --}}
                        <a href="{{ route('login') }}" class="btn btn-danger shadow-sm">Iniciar Sesión</a>
                        <a href="{{ route('register') }}" class="btn btn-outline-danger">Crear Cuenta</a>
                    </div>
                @endauth

            </div>
        </div>
    </div>
</div>
@endsection