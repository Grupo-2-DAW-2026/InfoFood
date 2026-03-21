{{-- Inicio del documento HTML5 con el atributo de idioma configurado en español --}}
<!DOCTYPE html>
<html lang="es">
<head>
    {{-- Configuración de la codificación de caracteres estándar --}}
    <meta charset="UTF-8">
    {{-- Meta para asegurar que el diseño sea responsive en dispositivos móviles --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Título de la web que concatena 'InfoFood' con el contenido de la sección 'title' de cada vista --}}
    <title>InfoFood @yield('title')</title>
    {{-- Enlace a la hoja de estilos de Bootstrap 5 desde CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Enlace a la librería de iconos oficiales de Bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    {{-- Bloque de estilos CSS internos para ajustes rápidos de diseño --}}
    <style>
        .navbar-brand img { height: 40px; }
        body { background-color: #f8f9fa; }
    </style>
</head>
<body>

    {{-- Inicio de la barra de navegación superior con fondo rojo y sombra --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger shadow-sm">
        <div class="container">
            {{-- Logotipo principal de la aplicación que apunta a la raíz del sitio --}}
            <a class="navbar-brand" href="{{ url('/') }}">INFOFOOD <strong>BETA</strong></a>
            
            {{-- Sección derecha de la navegación para la gestión de usuarios --}}
            <div class="ms-auto">
                {{-- Verifica si el sistema tiene habilitadas las rutas de login --}}
                @if (Route::has('login'))
                    <div class="d-flex align-items-center">
                        {{-- Contenido visible solo para usuarios que han iniciado sesión --}}
                        @auth
                            {{-- Enlace al panel de administración o dashboard personal --}}
                            <a href="{{ url('/dashboard') }}" class="btn btn-outline-light btn-sm me-2">Panel Control</a>
                            
                            {{-- Formulario para cerrar la sesión de forma segura mediante método POST --}}
                            <form method="POST" action="{{ route('logout') }}">
                                {{-- Token de seguridad para validar la petición de salida --}}
                                @csrf
                                <button type="submit" 
                                        class="btn btn-light btn-sm" 
                                        {{-- Confirmación visual mediante JavaScript antes de proceder al cierre --}}
                                        onclick="return confirm('¿Estás seguro de que deseas cerrar la sesión?')">
                                    Cerrar Sesión
                                </button>
                            </form>
                        @else
                            {{-- Bloque para usuarios no identificados (actualmente vacío) --}}
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </nav>

    {{-- Contenedor principal donde se inyectará el contenido específico de cada página --}}
    <div class="container mt-5">
        @yield('content')
    </div>

    {{-- Sección de pie de página estática con derechos de autor --}}
    <footer class="text-center mt-5 py-3 text-muted">
            {{-- Separador visual horizontal --}}
            <hr class="w-25 mx-auto">
            {{-- Etiqueta de derechos de autor con el año y nombre del proyecto --}}
            <small>&copy; 2026 InfoFood</small>
    </footer>

    {{-- Script de JavaScript de Bootstrap para funcionalidades interactivas como modales o menús desplegables --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>