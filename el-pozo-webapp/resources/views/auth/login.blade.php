<x-guest-layout>
    <h3 class="fw-bold text-center mb-4">Acceso Usuarios</h3>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label text-muted small fw-bold">CORREO ELECTRÓNICO</label>
            <input type="email" name="email" class="form-control form-control-lg" required autofocus>
            @if($errors->has('email'))
                <span class="text-danger small">{{ $errors->first('email') }}</span>
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label text-muted small fw-bold">CONTRASEÑA</label>
            <input type="password" name="password" class="form-control form-control-lg" required>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-danger btn-lg shadow-sm">Entrar al Sistema</button>
            <a href="{{ route('register') }}" class="btn btn-link text-muted text-decoration-none small">¿No tienes cuenta? Regístrate</a>
        </div>
    </form>
</x-guest-layout>