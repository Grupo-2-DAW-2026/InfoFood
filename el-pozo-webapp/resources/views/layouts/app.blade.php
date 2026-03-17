<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfoFood</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-brand img { height: 40px; }
        body { background-color: #f8f9fa; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-danger shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">INFOFOOD <strong>BETA</strong></a>
            
            <div class="ms-auto">
                @if (Route::has('login'))
                    <div>
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-outline-light btn-sm">Panel Control</a>
                        @else
                            <a href="{{ route('login') }}" class="text-white me-3 text-decoration-none">Entrar</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-light btn-sm">Registro</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        @yield('content')
    </div>

    <footer class="text-center mt-5 py-3 text-muted">
            <hr class="w-25 mx-auto">
            <small>&copy; 2026 InfoFood</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>