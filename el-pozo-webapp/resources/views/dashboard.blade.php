@extends('layouts.app')

@section("title" , "- Panel de Control")

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm border-0 rounded-4 text-center p-4">
            <div class="mb-3">
                <div class="bg-danger text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 2rem;">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
            <h4 class="fw-bold">{{ Auth::user()->name }}</h4>
            <span class="badge {{ Auth::user()->role == 'admin' ? 'bg-dark' : 'bg-secondary' }} mb-3">
                {{ strtoupper(Auth::user()->role) }}
            </span>
            <p class="text-muted small">{{ Auth::user()->email }}</p>
            <hr>
            <div class="d-grid">
                <a href="{{ route('profile.edit') }}" class="btn btn-outline-danger btn-sm">Editar Perfil</a>
            </div>
        </div>
    </div>
</div>
@endsection