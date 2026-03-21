{{-- Inicio de la barra de navegación con estilos de Bootstrap: expansión en pantallas grandes, esquema oscuro y fondo rojo --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-danger shadow-sm">
    {{-- Contenedor central para alinear los elementos de la barra --}}
    <div class="container">
        {{-- Logotipo o nombre de la marca que redirige a la página de inicio --}}
        <a class="navbar-brand" href="{{ url('/') }}">INFOFOOD <strong>BETA</strong></a>
        
        {{-- Div posicionado a la derecha para futuros elementos del menú o autenticación --}}
        <div class="ms-auto">
    </div>
{{-- Cierre de la etiqueta de navegación --}}
</nav>