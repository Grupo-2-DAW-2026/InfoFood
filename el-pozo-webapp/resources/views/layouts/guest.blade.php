{{-- Definición del tipo de documento HTML5 --}}
<!DOCTYPE html>
<html lang="es">
<head>
    {{-- Juego de caracteres para soportar tildes y eñes --}}
    <meta charset="UTF-8">
    {{-- Adaptación del ancho de pantalla para visualización móvil --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Título fijo para las pantallas de invitados (Login, Registro, etc.) --}}
    <title>InfoFood - Acceso</title>
    {{-- Importación de Bootstrap 5 para el diseño de rejillas y componentes --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Estilos específicos para la página de acceso, centrando la atención en el formulario --}}
    <style>
        body { background-color: #f8f9fa; }
        .card { border: none; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15); }
    </style>
</head>
<body>
    {{-- Inclusión del fragmento de la barra de navegación desde la carpeta partials --}}
    @include('partials.navbar')

    {{-- Contenedor principal para el formulario de acceso --}}
    <div class="container">
        {{-- Fila que utiliza Flexbox para centrar la tarjeta verticalmente en toda la altura de la pantalla (vh-100) --}}
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-5">
                {{-- Espacio superior opcional para logotipos o mensajes de bienvenida --}}
                <div class="text-center mb-4">
                </div>
                {{-- Tarjeta blanca con bordes redondeados donde se inyectará el contenido dinámico del componente --}}
                <div class="card rounded-4 p-4">
                    {{-- Variable de Laravel que representa el contenido pasado al componente --}}
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>

    {{-- Inclusión del fragmento del pie de página desde la carpeta partials --}}
    @include('partials.footer')
</body>
</html>