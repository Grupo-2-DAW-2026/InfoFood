<head>
    <link rel="icon" type="image/png" href="https://dapatloker.com/wp-content/uploads/2025/12/Indofood-Sukses-Makmur-Tbk-90x90.png">
</head>
<x-guest-layout>
    <h3 class="fw-bold text-center mb-4">Nuevo Usuario</h3>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label text-muted small fw-bold">NOMBRE COMPLETO</label>
            <input type="text" name="name" class="form-control" required autofocus>
        </div>

        <div class="mb-3">
            <label class="form-label text-muted small fw-bold">CORREO ELECTRÓNICO</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label text-muted small fw-bold">CONTRASEÑA</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-4">
            <label class="form-label text-muted small fw-bold">CONFIRMAR CONTRASEÑA</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-danger btn-lg shadow-sm">Crear Cuenta</button>
            <a href="{{ route('login') }}" class="btn btn-link text-muted text-decoration-none small">¿Ya estás registrado? Iniciar Sesión</a>
        </div>
    </form>
</x-guest-layout>