 {{-- Hereda el diseño base de la aplicación --}}
@extends('layouts.app')

 {{-- Define el título de la página --}}
@section("title" , "- Editar Perfil")

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3 class="fw-bold mb-4 text-danger">Ajustes de mi Perfil</h3>

            {{-- Bloque 1: Información básica del usuario (Nombre y Email) --}}
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Información del Perfil</h5>
                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf {{-- Token de seguridad para formularios --}}
                        @method('patch') {{-- Define que la petición es de tipo PATCH para actualizar --}}

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">NOMBRE COMPLETO</label>
                            <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">CORREO ELECTRÓNICO</label>
                            <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}" required>
                        </div>

                        <button type="submit" class="btn btn-danger px-4 shadow-sm">Guardar Cambios</button>
                    </form>
                </div>
            </div>

            {{-- Bloque 2: Cambio de contraseña --}}
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Seguridad y Contraseña</h5>
                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put') {{-- Define que la petición es de tipo PUT para actualizar contraseña --}}

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">CONTRASEÑA ACTUAL</label>
                            <input type="password" name="current_password" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">NUEVA CONTRASEÑA</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">CONFIRMAR NUEVA CONTRASEÑA</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-dark px-4 shadow-sm">Actualizar Contraseña</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection