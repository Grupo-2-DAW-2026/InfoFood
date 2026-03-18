@extends('layouts.app')

@section("title" , "- Catálogo")

@section('content')
<div class="container mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark">Catálogo <span class="text-danger">InfoFood</span></h2>
            <p class="text-muted">Explora la trazabilidad de nuestros productos.</p>
        </div>
        <a href="{{ route('productos.crear') }}" class="btn btn-danger shadow-sm">+ Añadir Producto</a>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($productos as $producto)
            <div class="col">
                <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden position-relative">
                    
                    {{-- MARCADOR "BUSCADO" (Si el producto no lo creó el usuario actual) --}}
                    @if($producto->user_id !== Auth::id())
                        <span class="badge bg-info text-white position-absolute top-0 end-0 m-3 shadow-sm" style="z-index: 10;">
                            <i class="bi bi-eye-fill me-1"></i> BUSCADO
                        </span>
                    @endif

                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                        @if($producto->imagen_url)
                            <img src="{{ $producto->imagen_url }}" class="img-fluid p-3" style="max-height: 100%;" alt="{{ $producto->nombre }}">
                        @else
                            <i class="bi bi-box-seam display-1 text-muted"></i>
                        @endif
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title fw-bold m-0">{{ $producto->nombre }}</h5>
                            <span class="badge bg-light text-dark border small">{{ $producto->ean_13 }}</span>
                        </div>
                        
                        <div class="mb-3">
                            @foreach($producto->alergenos as $alergeno)
                                <span class="badge bg-warning text-dark me-1 mb-1" title="{{ $alergeno->nombre }}">
                                    {{ strtoupper(substr($alergeno->nombre, 0, 3)) }}
                                </span>
                            @endforeach
                        </div>

                        <p class="text-muted small text-truncate">
                            {{ $producto->ingredientes ? $producto->ingredientes->nombre : 'Sin ingredientes registrados.' }}
                        </p>
                    </div>

                    <div class="card-footer bg-white border-0 pb-3">
                        <div class="d-grid gap-2">
                            {{-- SI ES EL DUEÑO O ADMIN: PUEDE EDITAR/VER --}}
                            @if(Auth::id() === $producto->user_id || Auth::user()->role === 'admin')
                                <div class="btn-group w-100">
                                    <a href="{{ route('productos.show', $producto->id) }}" class="btn btn-outline-danger btn-sm rounded-start-pill">Ver Ficha</a>
                                </div>
                            {{-- SI NO ES EL DUEÑO: SOLO VER FICHA --}}
                            @else
                                <a href="{{ route('productos.show', $producto->id) }}" class="btn btn-outline-danger btn-sm rounded-pill">Ver Ficha Completa</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($productos->isEmpty())
        <div class="text-center py-5">
            <h4 class="text-muted">No hay productos en el catálogo todavía.</h4>
        </div>
    @endif
</div>
@endsection