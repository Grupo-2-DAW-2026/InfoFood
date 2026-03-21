{{-- Directiva que indica que esta vista utiliza la plantilla base layouts/app.blade.php --}}
@extends('layouts.app')

{{-- Define el título dinámico que aparecerá en la pestaña del navegador para esta página específica --}}
@section("title" , "- Crear Producto")

{{-- Inicia el bloque de contenido principal que se inyectará en la plantilla base --}}
@section('content')
<div class="container pb-5">
    {{-- Contenedor de ancho máximo 10 para centrar el formulario en la pantalla --}}
    <div class="row justify-content-center">
        <div class="col-md-10">
            {{-- Encabezado con botón de retorno y título principal de la sección --}}
            <div class="d-flex align-items-center mb-4">
                <a href="{{ url('/') }}" class="btn btn-outline-danger btn-sm me-3 rounded-pill px-3">← Volver</a>
                <h2 class="fw-bold m-0 text-dark">Nuevo Producto <span class="text-danger">InfoFood</span></h2>
            </div>

            {{-- Inicio del formulario de creación que envía los datos a la ruta 'productos.store' mediante POST --}}
            <form action="{{ route('productos.store') }}" method="POST">
                {{-- Token de seguridad obligatorio de Laravel para prevenir ataques de falsificación de peticiones --}}
                @csrf

                {{-- Bloque de Identificación: Nombre, EAN e Imagen --}}
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-header bg-danger text-white fw-bold rounded-top-4 py-3">
                        <i class="bi bi-tag-fill me-2"></i> IDENTIFICACIÓN DEL PRODUCTO
                    </div>
                    <div class="card-body p-4 row">
                        {{-- Campo para introducir el nombre comercial del producto alimenticio --}}
                        <div class="col-md-7 mb-3">
                            <label class="form-label small fw-bold text-muted">NOMBRE COMERCIAL</label>
                            <input type="text" name="nombre" class="form-control form-control-lg border-2 shadow-sm" placeholder="Ej: Jamón Cocido Extra El Pozo" required>
                        </div>
                        {{-- Campo para el código de barras estándar de 13 dígitos --}}
                        <div class="col-md-5 mb-3">
                            <label class="form-label small fw-bold text-muted">CÓDIGO EAN-13 (BARRAS)</label>
                            <input type="text" name="ean_13" class="form-control form-control-lg border-2 shadow-sm" placeholder="8410101000001" required>
                        </div>
                        {{-- Campo para la dirección URL de la fotografía del producto --}}
                        <div class="col-md-12">
                            <label class="form-label small fw-bold text-muted">URL IMAGEN DEL PRODUCTO (CATÁLOGO)</label>
                            <input type="url" name="imagen_url" class="form-control border-2 shadow-sm" placeholder="https://www.elpozo.com/assets/producto.png">
                        </div>
                    </div>
                </div>

                {{-- Bloque de Ingredientes: Texto largo para la composición detallada --}}
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-header bg-secondary text-white fw-bold py-3">
                        <i class="bi bi-card-text me-2"></i> INGREDIENTES Y COMPOSICIÓN
                    </div>
                    <div class="card-body p-4">
                        <label class="form-label small fw-bold text-muted">LISTADO COMPLETO DE INGREDIENTES</label>
                        <textarea name="ingredientes" class="form-control border-2 shadow-sm" rows="3" placeholder="Jamón de cerdo (90%), agua, sal, estabilizantes (E-451i, E-407), aromas..." required></textarea>
                    </div>
                </div>

                {{-- Bloque Nutricional: Campos numéricos para los valores por cada 100 gramos --}}
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-header bg-dark text-white fw-bold py-3">
                        <i class="bi bi-graph-up me-2"></i> INFORMACIÓN NUTRICIONAL (POR 100g)
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-3"><label class="small fw-bold text-muted">KCAL</label><input type="number" step="0.01" name="kcal" class="form-control" required></div>
                            <div class="col-md-3"><label class="small fw-bold text-muted">GRASAS (G)</label><input type="number" step="0.01" name="grasas_totales" class="form-control" required></div>
                            <div class="col-md-3"><label class="small fw-bold text-muted">SATURADAS (G)</label><input type="number" step="0.01" name="grasas_saturadas" class="form-control" required></div>
                            <div class="col-md-3"><label class="small fw-bold text-muted">HIDRATOS (G)</label><input type="number" step="0.01" name="hidratos" class="form-control" required></div>
                            <div class="col-md-3"><label class="small fw-bold text-muted">AZÚCARES (G)</label><input type="number" step="0.01" name="azucares" class="form-control" required></div>
                            <div class="col-md-3"><label class="small fw-bold text-muted">PROTEÍNAS (G)</label><input type="number" step="0.01" name="proteinas" class="form-control" required></div>
                            <div class="col-md-3"><label class="small fw-bold text-muted">SAL (G)</label><input type="number" step="0.01" name="sal" class="form-control" required></div>
                        </div>
                    </div>
                </div>

                {{-- Bloque de Trazabilidad: Información de origen, lote y fechas --}}
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-header bg-success text-white fw-bold py-3">
                        <i class="bi bi-geo-alt-fill me-2"></i> DATOS DE TRAZABILIDAD
                    </div>
                    <div class="card-body p-4 row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label small fw-bold text-muted">LOTE</label>
                            <input type="text" name="lote" class="form-control border-2 shadow-sm" placeholder="L-2309AA">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label small fw-bold text-muted">ORIGEN MATERIA PRIMA</label>
                            <input type="text" name="origen_materia_prima" class="form-control border-2 shadow-sm" placeholder="Granjas El Pozo (Murcia)">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label small fw-bold text-muted">FECHA ENVASADO</label>
                            <input type="date" name="fecha_envasado" class="form-control border-2 shadow-sm">
                        </div>
                    </div>
                </div>

                {{-- Bloque de Alérgenos: Selección mediante switches de los alérgenos de declaración obligatoria --}}
                <div class="card shadow-sm border-0 rounded-4 mb-5">
                    <div class="card-header bg-warning text-dark fw-bold py-3">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> ALÉRGENOS PRESENTES
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            {{-- Definición del array con la lista estándar de alérgenos alimentarios --}}
                            @php 
                                $alergenos = ['Gluten', 'Crustáceos', 'Huevos', 'Pescado', 'Cacahuetes', 'Soja', 'Lácteos', 'Frutos de cáscara', 'Apio', 'Mostaza', 'Sésamo', 'Sulfitos', 'Altramuces', 'Moluscos']; 
                            @endphp
                            {{-- Bucle para generar automáticamente los inputs de cada alérgeno --}}
                            @foreach($alergenos as $item)
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="alergenos[]" value="{{ $item }}" id="aler_{{ $loop->index }}">
                                        <label class="form-check-label small fw-bold" for="aler_{{ $loop->index }}">{{ strtoupper($item) }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Botón final para enviar el formulario y guardar el producto en la base de datos --}}
                <div class="d-grid mb-5">
                    <button type="submit" class="btn btn-danger btn-lg py-3 shadow-lg fw-bold rounded-4">
                        PUBLICAR PRODUCTO EN EL CATÁLOGO
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection