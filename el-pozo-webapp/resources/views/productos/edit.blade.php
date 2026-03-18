@extends('layouts.app')

@section("title" , "- Editar Producto")

@section('content')
<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('productos.show', $producto->id) }}" class="btn btn-outline-danger btn-sm me-3 rounded-pill px-3">← Volver</a>
                <h2 class="fw-bold m-0 text-dark">Editar: <span class="text-danger">{{ $producto->nombre }}</span></h2>
            </div>

            <form action="{{ route('productos.update', $producto->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-header bg-danger text-white fw-bold py-3">IDENTIFICACIÓN</div>
                    <div class="card-body p-4 row">
                        <div class="col-md-6 mb-3">
                            <label class="small fw-bold text-muted">NOMBRE COMERCIAL</label>
                            <input type="text" name="nombre" class="form-control" value="{{ $producto->nombre }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small fw-bold text-muted">CÓDIGO EAN-13</label>
                            <input type="text" name="ean_13" class="form-control" value="{{ $producto->ean_13 }}" required>
                        </div>
                        <div class="col-12">
                            <label class="small fw-bold text-muted">URL IMAGEN</label>
                            <input type="url" name="imagen_url" class="form-control" value="{{ $producto->imagen_url }}">
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-header bg-secondary text-white fw-bold py-3">INGREDIENTES</div>
                    <div class="card-body p-4">
                        <textarea name="ingredientes" class="form-control" rows="3" required>{{ $producto->ingredientes->nombre ?? '' }}</textarea>
                    </div>
                </div>

                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-header bg-dark text-white fw-bold py-3">INFORMACIÓN NUTRICIONAL (POR 100g)</div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="small fw-bold text-muted">KCAL</label>
                                <input type="number" step="0.01" name="kcal" class="form-control" value="{{ $producto->nutricion->kcal ?? '' }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="small fw-bold text-muted">GRASAS (G)</label>
                                <input type="number" step="0.01" name="grasas_totales" class="form-control" value="{{ $producto->nutricion->grasas_totales ?? '' }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="small fw-bold text-muted">SATURADAS (G)</label>
                                <input type="number" step="0.01" name="grasas_saturadas" class="form-control" value="{{ $producto->nutricion->grasas_saturadas ?? '' }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="small fw-bold text-muted">HIDRATOS (G)</label>
                                <input type="number" step="0.01" name="hidratos" class="form-control" value="{{ $producto->nutricion->hidratos ?? '' }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="small fw-bold text-muted">AZÚCARES (G)</label>
                                <input type="number" step="0.01" name="azucares" class="form-control" value="{{ $producto->nutricion->azucares ?? '' }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="small fw-bold text-muted">PROTEÍNAS (G)</label>
                                <input type="number" step="0.01" name="proteinas" class="form-control" value="{{ $producto->nutricion->proteinas ?? '' }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="small fw-bold text-muted">SAL (G)</label>
                                <input type="number" step="0.01" name="sal" class="form-control" value="{{ $producto->nutricion->sal ?? '' }}" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 rounded-4 mb-5">
                    <div class="card-header bg-warning text-dark fw-bold py-3">ALÉRGENOS</div>
                    <div class="card-body p-4">
                        <div class="row">
                            @php 
                                $listaAlergenos = ['Gluten', 'Crustáceos', 'Huevos', 'Pescado', 'Cacahuetes', 'Soja', 'Lácteos', 'Frutos de cáscara', 'Apio', 'Mostaza', 'Sésamo', 'Sulfitos', 'Altramuces', 'Moluscos']; 
                                $actuales = $producto->alergenos->pluck('nombre')->toArray(); 
                            @endphp
                            @foreach($listaAlergenos as $item)
                                <div class="col-md-3 col-6 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="alergenos[]" value="{{ $item }}" id="check_{{ $loop->index }}" 
                                            {{ in_array($item, $actuales) ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="check_{{ $loop->index }}">{{ $item }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-success btn-lg fw-bold rounded-4 shadow">
                        GUARDAR CAMBIOS ACTUALIZADOS
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection