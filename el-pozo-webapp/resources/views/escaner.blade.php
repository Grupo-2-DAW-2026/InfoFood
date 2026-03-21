 {{-- Hereda la plantilla base (Navbar, Footer, Bootstrap) --}}
@extends('layouts.app')

 {{-- Define el título específico de esta pestaña --}}
@section("title","- Escanear Producto")

@section('content')
<div class="container text-center pb-5">
    <h2 class="mb-4 fw-bold">Escanear Código de Barras</h2>
    
    {{-- Contenedor donde la librería de JS renderizará la cámara --}}
    <div id="reader" class="shadow-sm rounded-4 overflow-hidden border" style="width: 100%; max-width: 500px; margin: auto;"></div>
    
    {{-- Mensaje informativo que aparece al detectar un código --}}
    <div id="resultado" class="mt-3 alert alert-info" style="display:none;">
        Buscando producto...
    </div>

    {{-- Bloque de Error: Se activa por JS si el servidor devuelve un 404 (No encontrado) --}}
    <div id="contenedor_error" class="mt-4 mx-auto" style="max-width: 500px; display:none;">
        <div class="alert alert-danger border-0 shadow-sm mb-3">
            <i class="bi bi-exclamation-circle-fill"></i> 
            <span>El producto no existe o no se encuentra en el sistema.</span>
        </div>

        @auth {{-- Solo si el usuario está logueado puede ver el botón de añadir --}}
            {{-- Botón que redirige al formulario de creación --}}
            <a href="{{ route('productos.crear') }}" class="btn btn-dark w-100 fw-bold rounded-pill shadow-sm">
                <i class="bi bi-plus-lg"></i> AÑADIR NUEVO PRODUCTO
            </a>
        @else {{-- Si es un visitante anónimo, le pedimos que se identifique --}}
            <div class="alert alert-warning border-0 shadow-sm small">
                <i class="bi bi-lock-fill"></i> 
                Para añadir este producto, primero debes <a href="{{ route('login') }}" class="fw-bold text-dark">iniciar sesión</a>.
            </div>
        @endauth
    </div>

    {{-- Bloque de Búsqueda Manual: Alternativa por si falla la cámara --}}
    <div class="mt-5 p-4 bg-light rounded-4 border shadow-sm mx-auto" style="max-width: 500px;">
        <p class="text-muted small fw-bold text-uppercase">¿No funciona la cámara?</p>
        <h5 class="mb-3">Introduce el código manualmente</h5>
        
        <div class="input-group">
            {{-- Input con restricción por JS para que solo admita números --}}
            <input type="text" 
                   id="ean_manual" 
                   class="form-control form-control-lg border-2" 
                   placeholder="Ej: 8410843144007"
                   maxlength="13"
                   oninput="this.value = this.value.replace(/[^0-9]/g, '')"> 
            <button class="btn btn-danger px-4 fw-bold" type="button" onclick="buscarManual()">
                BUSCAR
            </button>
        </div>
    </div>
</div>

    {{-- Alerta de errores de sesión (por ejemplo, si falla la redirección) --}}
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-3">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('error') }}
        </div>
    @endif

{{-- Importación de la librería externa para lectura de códigos QR/EAN --}}
<script src="https://unpkg.com/html5-qrcode"></script>

<script>
    /**
     * FUNCIÓN DE ÉXITO AL ESCANEAR
     * Se activa automáticamente cuando la cámara detecta un código.
     */
    function onScanSuccess(decodedText, decodedResult) {
        // Limpiamos la cámara para evitar múltiples escaneos simultáneos
        html5QrcodeScanner.clear().then(() => {
            ejecutarBusqueda(decodedText);
        }).catch(err => {
            ejecutarBusqueda(decodedText);
        });
    }

    /**
     * FUNCIÓN PARA EL BOTÓN MANUAL
     * Valida que el código tenga una longitud mínima antes de enviarlo.
     */
    function buscarManual() {
        const ean = document.getElementById('ean_manual').value;
        if (ean.length < 8) {
            alert("Por favor, introduce un código válido.");
            return;
        }
        ejecutarBusqueda(ean);
    }

    /**
     * FUNCIÓN CENTRAL DE BÚSQUEDA (AJAX/FETCH)
     * Se comunica con Laravel para ver si el producto existe.
     */
    function ejecutarBusqueda(ean) {
        const resDiv = document.getElementById('resultado');
        const errDiv = document.getElementById('contenedor_error');
        
        // UI: Mostramos que estamos buscando y ocultamos errores previos
        if(resDiv) {
            resDiv.style.display = 'block';
            resDiv.innerText = "Buscando código: " + ean;
        }
        if(errDiv) errDiv.style.display = 'none';

        // Petición asíncrona a la ruta de búsqueda
        fetch(`/buscar-producto/${ean}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            // Si el controlador devuelve un error (404), lanzamos excepción al catch
            if (!response.ok) throw new Error('No encontrado');
            return response.json();
        })
        .then(data => {
            // Si el controlador nos devuelve la URL del producto, redirigimos
            if (data.url) {
                window.location.href = data.url; 
            }
        })
        .catch(err => {
            // UI: En caso de error, ocultamos la carga y mostramos el error (con el botón de añadir)
            if(resDiv) resDiv.style.display = 'none';
            if(errDiv) errDiv.style.display = 'block';
        });
    }

    /**
     * CONFIGURACIÓN E INICIO DEL ESCÁNER
     */
    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", { 
            fps: 10, // Cuadros por segundo para el procesado
            qrbox: {width: 250, height: 150}, // Área visual del escáner
            rememberLastUsedCamera: true // Recuerda si el usuario usó la frontal o trasera
        }
    );
    html5QrcodeScanner.render(onScanSuccess); // Inicia el renderizado

    /**
     * TRADUCTOR DINÁMICO
     * Como la librería es nativa en inglés, buscamos los elementos por ID/Texto y los traducimos.
     */
    const traducirEscaner = () => {
        const traducciones = {
            "Scan an Image File": "Escanear un archivo de imagen",
            "Scan using camera directly": "Escanear usando la cámara directamente",
            "Select Camera": "Seleccionar Cámara",
            "Choose Image": "Elegir Imagen",
            "No image choosed": "No se ha elegido imagen",
            "Request Camera Permissions": "Solicitar Permiso de Cámara",
            "NotFoundError: Requested device not found": "No se detecta ninguna cámara en este dispositivo",
            "NotAllowedError: Permission denied": "Acceso denegado a la cámara"
        };

        // Mapeo específico de los botones internos de la librería
        const mapeoBotones = {
            'html5-qrcode-button-camera-start': "Iniciar Cámara",
            'html5-qrcode-button-camera-stop': "Detener Cámara",
            'html5-qrcode-button-camera-permission': "Conceder Permiso",
            'html5-qrcode-button-file-selection': "Elegir Imagen"
        };

        // Aplicamos el cambio de texto a los botones
        Object.keys(mapeoBotones).forEach(id => {
            const btn = document.getElementById(id);
            if (btn && btn.innerText !== mapeoBotones[id]) {
                btn.innerText = mapeoBotones[id];
            }
        });

        // Buscamos textos sueltos dentro del lector para traducirlos
        const todosLosElementos = document.querySelectorAll('#reader *');
        todosLosElementos.forEach(el => {
            if (el.children.length === 0 && el.innerText.trim() !== "") {
                Object.keys(traducciones).forEach(key => {
                    if (el.innerText.includes(key)) {
                        el.innerText = traducciones[key];
                    }
                });
            }
        });
    };

    // Ejecutamos la traducción cada 500ms porque la librería regenera elementos al cambiar de modo
    setInterval(traducirEscaner, 500);
</script>
@endsection