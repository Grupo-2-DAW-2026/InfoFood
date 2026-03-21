{{-- Directiva para extender la plantilla maestra que contiene el HEAD y el FOOTER --}}
@extends('layouts.app')

{{-- Insertamos el título dinámico en el stack definido en el layout --}}
@section("title" , "- Perfil")

@section('content')
{{-- justify-content-center: centra la tarjeta horizontalmente --}}
<div class="row justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="col-md-4">
        {{-- Tarjeta de perfil con estilo minimalista --}}
        <div class="card shadow-sm border-0 rounded-4 text-center p-4">
            
            {{-- SECCIÓN DE AVATAR --}}
            <div class="mb-3">
                {{-- d-inline-flex: para que el círculo se ajuste al contenido; rounded-circle: forma redonda --}}
                <div class="bg-danger text-white rounded-circle d-inline-flex align-items-center justify-content-center" 
                     style="width: 80px; height: 80px; font-size: 2rem; font-weight: bold;">
                    {{-- substr: función de PHP para extraer la primera letra del nombre del usuario --}}
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>

            {{-- DATOS DEL USUARIO --}}
            <h4 class="fw-bold mb-0">{{ Auth::user()->name }}</h4>
            
            {{-- Renderizado condicional de clases de Bootstrap para el rol --}}
            <div class="my-3">
                <span class="badge {{ Auth::user()->role == 'admin' ? 'bg-dark' : 'bg-secondary' }} px-3 py-2">
                    {{ strtoupper(Auth::user()->role) }} {{-- strtoupper: convierte el texto a mayúsculas --}}
                </span>
            </div>

            <p class="text-muted mb-4">
                <i class="bi bi-envelope me-1"></i> {{ Auth::user()->email }}
            </p>
            
            <hr class="text-muted opacity-25"> {{-- Separador visual suave --}}
            
            {{-- ACCIONES --}}
            <div class="d-grid">
                {{-- Botón para ir a la vista de edición del perfil gestionada por Breeze --}}
                <a href="{{ route('profile.edit') }}" class="btn btn-outline-danger btn-sm rounded-pill">
                    <i class="bi bi-pencil-square"></i> Configuración de Cuenta
                </a>
            </div>

        </div>
    </div>
</div>
@endsection