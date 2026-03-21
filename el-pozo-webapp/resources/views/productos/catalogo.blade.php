{{-- Extiende el diseño base de la aplicación --}}
@extends('layouts.app')

{{-- Define el título específico de la página --}}
@section("title" , "- Catálogo")

@section('content')
<div class="container mb-5">
    {{-- CABECERA: Título y botón de añadir (solo para usuarios logueados) --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark">Catálogo <span class="text-danger">InfoFood</span></h2>
            <p class="text-muted">Explora la trazabilidad de nuestros productos.</p>
        </div>
        {{-- Verificamos si el usuario está autenticado para mostrar el botón de crear --}}
        @auth
            <a href="{{ route('productos.crear') }}" class="btn btn-danger shadow-sm">+ Añadir Producto</a>
        @endauth
    </div>

    {{-- REJILLA DE PRODUCTOS: Bucle para mostrar cada producto en una tarjeta --}}
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($productos as $producto)
            <div class="col">
                <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden position-relative">
                    
                    {{-- MARCADOR "BUSCADO": Aparece si el producto NO fue creado por el usuario actual --}}
                    @if(Auth::check() && $producto->user_id !== Auth::id())
                        <span class="badge bg-info text-white position-absolute top-0 end-0 m-3 shadow-sm" style="z-index: 10;">
                            <i class="bi bi-eye-fill me-1"></i> BUSCADO
                        </span>
                    @endif

                    {{-- IMAGEN: Muestra la imagen del producto o un icono por defecto --}}
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                        @if($producto->imagen_url)
                            <img src="{{ $producto->imagen_url }}" class="img-fluid h-100 w-100 object-fit-cover" alt="{{ $producto->nombre }}">
                        @else
                            <i class="bi bi-box-seam text-muted display-1"></i>
                        @endif
                    </div>

                    {{-- CUERPO: Nombre, EAN e ingredientes --}}
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-1">{{ $producto->nombre }}</h5>
                        <p class="text-danger small mb-3 fw-bold">EAN: {{ $producto->ean_13 }}</p>
                        
                        {{-- LISTADO DE INGREDIENTES: Usamos pluck e implode para evitar el error de colección --}}
                        <p class="text-muted small text-truncate">
                            <strong>Ingredientes:</strong> 
                            {{ $producto->ingredientes ? $producto->ingredientes->nombre : 'Sin ingredientes registrados.' }}                        
                        </p>
                    </div>

                    {{-- PIE DE TARJETA: Botones de ver ficha --}}
                    <div class="card-footer bg-white border-0 pb-3">
                        <div class="d-grid gap-2">
                            <a href="{{ route('productos.show', $producto->id) }}" class="btn btn-outline-danger btn-sm rounded-pill">
                                Ver Ficha Completa
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- MENSAJE DE CATÁLOGO VACÍO --}}
    @if($productos->isEmpty())
        <div class="text-center py-5">
            <h4 class="text-muted">No hay productos en el catálogo todavía.</h4>
        </div>
    @endif
</div>
@endsection