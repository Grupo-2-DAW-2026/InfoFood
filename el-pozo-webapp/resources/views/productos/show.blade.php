@extends('layouts.app')

@section("title", "- " . $producto->nombre)

@section('content')
<div class="container pb-5">
    <div class="d-flex align-items-center justify-content-between mb-4 pt-3">
        <div class="d-flex align-items-center">
            @auth
                <a href="{{ route('productos.catalogo') }}" class="btn btn-outline-danger btn-sm me-3 rounded-pill px-3">
                    <i class="bi bi-arrow-left"></i> Catálogo
                </a>
            @else
                <a href="{{ route('welcome') }}" class="btn btn-outline-secondary btn-sm me-3 rounded-pill px-3">
                    <i class="bi bi-house"></i> Inicio
                </a>
            @endauth
            <h2 class="fw-bold m-0 text-dark">Ficha Técnica <span class="text-danger">InfoFood</span></h2>
        </div>

        <div class="d-flex gap-2">
            {{-- BOTÓN EDITAR (Si es admin o dueño) --}}
            @if(Auth::user() && (Auth::user()->role == 'admin' || Auth::user()->id == $producto->user_id))
                <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-dark btn-sm rounded-pill px-4 shadow-sm">
                    <i class="bi bi-pencil-square me-1"></i> Editar Producto
                </a>

                {{-- BOTÓN BORRAR --}}
                <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este producto? Esta acción no se puede deshacer.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-4 shadow-sm">
                        <i class="bi bi-trash3 me-1"></i> Borrar Producto
                    </button>
                </form>
            @endif

            <button type="button" class="btn btn-outline-warning btn-sm fw-bold shadow-sm">
                <i class="bi bi-flag-fill me-1"></i> SOLICITAR REVISIÓN
            </button>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 sticky-top" style="top: 20px;">
                <div class="card-body text-center p-4">
                    @if($producto->imagen_url)
                        <img src="{{ $producto->imagen_url }}" class="img-fluid mb-3 p-2 bg-light rounded-4" style="max-height: 250px;" alt="{{ $producto->nombre }}">
                    @else
                        <div class="bg-light rounded-4 d-flex align-items-center justify-content-center mb-3" style="height: 250px;">
                            <i class="bi bi-box-seam display-1 text-muted"></i>
                        </div>
                    @endif
                    
                    <h1 class="fw-bold h3 text-dark">{{ $producto->nombre }}</h1>
                    <span class="badge bg-danger px-3 py-2 rounded-pill mb-3">
                        <i class="bi bi-barcode me-1"></i> EAN: {{ $producto->ean_13 }}
                    </span>
                    
                    <div class="text-muted small">
                        <i class="bi bi-person-circle me-1"></i> Publicado por: <strong>{{ $producto->user->name ?? 'Usuario Anónimo' }}</strong>
                    </div>

                    <hr class="my-4">

                    <h5 class="fw-bold text-muted mb-3 text-start">
                        <i class="bi bi-exclamation-triangle-fill text-warning me-1"></i> Alérgenos
                    </h5>
                    
                    <div class="row g-2">
                        @forelse($producto->alergenos as $alergeno)
                            <div class="col-6">
                                <div class="d-flex align-items-center border rounded-3 p-2 bg-light h-100 shadow-xs">
                                    @php
                                        $icon = 'bi-patch-question'; 
                                        $nameLower = strtolower($alergeno->nombre);
                                        if(str_contains($nameLower, 'gluten')) $icon = 'bi-wheat';
                                        elseif(str_contains($nameLower, 'lácteos') || str_contains($nameLower, 'leche')) $icon = 'bi-droplet-fill text-primary';
                                        elseif(str_contains($nameLower, 'huevos')) $icon = 'bi-egg-fried text-warning';
                                        elseif(str_contains($nameLower, 'soja')) $icon = 'bi-seedling text-success';
                                        elseif(str_contains($nameLower, 'pescado')) $icon = 'bi-fish text-info';
                                        elseif(str_contains($nameLower, 'frutos')) $icon = 'bi-nut text-secondary';
                                        elseif(str_contains($nameLower, 'sulfitos')) $icon = 'bi-funnel-fill';
                                    @endphp
                                    <i class="bi {{ $icon }} fs-4 me-2"></i>
                                    <span class="small fw-bold text-dark text-truncate">{{ strtoupper($alergeno->nombre) }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-start">
                                <p class="text-success small fw-bold">
                                    <i class="bi bi-check-circle-fill me-1"></i> Sin alérgenos declarados.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            {{-- Sección Ingredientes --}}
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h4 class="fw-bold text-dark m-0">
                        <i class="bi bi-card-text text-danger me-2"></i>Ingredientes
                    </h4>
                </div>
                <div class="card-body p-4">
                    @if($producto->ingredientes)
                        <p class="text-muted lh-lg bg-light p-3 rounded-3 border">
                            {{ $producto->ingredientes->nombre }}
                        </p>
                    @else
                        <p class="text-muted italic">No hay ingredientes registrados.</p>
                    @endif
                </div>
            </div>

            {{-- Sección Nutrición --}}
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h4 class="fw-bold text-dark m-0">
                        <i class="bi bi-graph-up text-danger me-2"></i>Información Nutricional (100g)
                    </h4>
                </div>
                <div class="card-body p-4">
                    @if($producto->nutricion)
                        <div class="row g-3 text-center">
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="bg-danger text-white rounded-4 p-3 shadow-sm">
                                    <div class="small opacity-75">ENERGÍA</div>
                                    <div class="display-6 fw-bold">{{ round($producto->nutricion->kcal) }}</div>
                                    <div class="fw-bold">kcal</div>
                                </div>
                            </div>
                            
                            @php
                                $nutrientes = [
                                    ['label' => 'GRASAS', 'value' => $producto->nutricion->grasas_totales, 'unit' => 'g', 'icon' => 'bi-droplet'],
                                    ['label' => 'SATURADAS', 'value' => $producto->nutricion->grasas_saturadas, 'unit' => 'g', 'icon' => 'bi-funnel'],
                                    ['label' => 'HIDRATOS', 'value' => $producto->nutricion->hidratos, 'unit' => 'g', 'icon' => 'bi-cake2'],
                                    ['label' => 'AZÚCARES', 'value' => $producto->nutricion->azucares, 'unit' => 'g', 'icon' => 'bi-potted-plant'],
                                    ['label' => 'PROTEÍNAS', 'value' => $producto->nutricion->proteinas, 'unit' => 'g', 'icon' => 'bi-shield-shaded'],
                                    ['label' => 'SAL', 'value' => $producto->nutricion->sal, 'unit' => 'g', 'icon' => 'bi-moisture'],
                                ];
                            @endphp

                            @foreach($nutrientes as $nutriente)
                                <div class="col-6 col-sm-3 col-md-4">
                                    <div class="border rounded-4 p-3 bg-light h-100 shadow-xs">
                                        <div class="text-muted small fw-bold">
                                            <i class="{{ $nutriente['icon'] }} me-1"></i>{{ $nutriente['label'] }}
                                        </div>
                                        <div class="h3 fw-bold text-dark m-0">{{ $nutriente['value'] }}<span class="fs-6 fw-normal text-muted">{{ $nutriente['unit'] }}</span></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted italic">Información nutricional no disponible.</p>
                    @endif
                </div>
            </div>

            {{-- Sección Trazabilidad --}}
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white border-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                    <h4 class="fw-bold text-dark m-0">
                        <i class="bi bi-geo-alt-fill text-danger me-2"></i>Línea de Trazabilidad
                    </h4>
                    
                    {{-- BOTÓN PARA ABRIR EL MODAL --}}
                    @if(Auth::user() && (Auth::user()->role == 'admin' || Auth::user()->id == $producto->user_id))
                        <button type="button" class="btn btn-danger btn-sm rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTrazabilidad">
                            <i class="bi bi-plus-lg me-1"></i> Añadir Paso
                        </button>
                    @endif
                </div>
                <div class="card-body p-4">
                    @php
                        $pasos = $producto->trazabilidad->sortBy('orden');
                    @endphp

                    @forelse($pasos as $paso)
                    <div class="d-flex mb-4 position-relative">
                        @if(!$loop->last)
                            <div class="position-absolute border-start border-2 border-danger" style="top: 35px; left: 17px; height: calc(100% - 10px); z-index: 1;"></div>
                        @endif
                        
                        <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 35px; height: 35px; z-index: 2; flex-shrink: 0;">
                            {{ $paso->orden }}
                        </div>
                        
                        <div class="ms-3 bg-light p-3 rounded-3 border w-100 shadow-xs position-relative">
                            {{-- BOTÓN ELIMINAR PASO (Solo para dueños/admin) --}}
                            @if(Auth::user() && (Auth::user()->role == 'admin' || Auth::user()->id == $producto->user_id))
                                <form action="{{ route('trazabilidad.destroy', $paso->id) }}" method="POST" class="position-absolute" style="top: 10px; right: 10px;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link text-muted p-0 hover-danger" onclick="return confirm('¿Borrar este paso?')">
                                        <i class="bi bi-x-circle-fill"></i>
                                    </button>
                                </form>
                            @endif

                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h6 class="fw-bold m-0 text-dark pe-4">{{ $paso->titulo }}</h6>
                                @if($paso->fecha_proceso)
                                    <span class="badge bg-white text-muted border small">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        {{ \Carbon\Carbon::parse($paso->fecha_proceso)->format('d/m/Y') }}
                                    </span>
                                @endif
                            </div>
                            <p class="text-muted small m-0 lh-base">{{ $paso->descripcion }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-3 text-muted">
                        <p>No hay pasos de trazabilidad registrados.</p>
                    </div>
                @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL INTEGRADO --}}
<div class="modal fade" id="modalTrazabilidad" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header bg-danger text-white rounded-top-4">
                <h5 class="modal-title fw-bold">Nuevo Paso de Trazabilidad</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('trazabilidad.store') }}" method="POST">
                @csrf
                <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="small fw-bold text-muted">TÍTULO DEL PROCESO</label>
                        <input type="text" name="titulo" class="form-control" placeholder="Ej: Control de Calidad" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="small fw-bold text-muted">ORDEN</label>
                            <input type="number" name="orden" class="form-control" value="{{ count($pasos) + 1 }}" required readonly>
                        </div>
                        <div class="col-6">
                            <label class="small fw-bold text-muted">FECHA</label>
                            <input type="date" name="fecha_proceso" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="mb-0">
                        <label class="small fw-bold text-muted">DESCRIPCIÓN</label>
                        <textarea name="descripcion" class="form-control" rows="3" placeholder="Detalles del proceso..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger rounded-pill px-4">Guardar Paso</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .shadow-xs {
        box-shadow: 0 .125rem .25rem rgba(0,0,0,0.03)!important;
    }
</style>
@endsection