@extends('layouts.app')

@section("title","- Escanear Producto")

@section('content')
<div class="container text-center pb-5">
    <h2 class="mb-4 fw-bold">Escanear Código de Barras</h2>
    
    <div id="reader" class="shadow-sm rounded-4 overflow-hidden border" style="width: 100%; max-width: 500px; margin: auto;"></div>
    
    <div id="resultado" class="mt-3 alert alert-info" style="display:none;">
        Buscando producto...
    </div>

    <div id="contenedor_error" class="mt-4 mx-auto" style="max-width: 500px; display:none;">
        <div class="alert alert-danger border-0 shadow-sm mb-3">
            <i class="bi bi-exclamation-circle-fill"></i> 
            <span>El producto no existe o no se encuentra en el sistema.</span>
        </div>

        @auth
            {{-- Si está logueado: Botón para añadir --}}
            <a href="{{ route('productos.crear') }}" class="btn btn-dark w-100 fw-bold rounded-pill shadow-sm">
                <i class="bi bi-plus-lg"></i> AÑADIR NUEVO PRODUCTO
            </a>
        @else
            {{-- Si NO está logueado: Mensaje de aviso --}}
            <div class="alert alert-warning border-0 shadow-sm small">
                <i class="bi bi-lock-fill"></i> 
                Para añadir este producto, primero debes <a href="{{ route('login') }}" class="fw-bold text-dark">iniciar sesión</a>.
            </div>
        @endauth
    </div>

    <div class="mt-5 p-4 bg-light rounded-4 border shadow-sm mx-auto" style="max-width: 500px;">
        <p class="text-muted small fw-bold text-uppercase">¿No funciona la cámara?</p>
        <h5 class="mb-3">Introduce el código manualmente</h5>
        
        <div class="input-group">
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

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-3">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('error') }}
        </div>
    @endif

<script src="https://unpkg.com/html5-qrcode"></script>

<script>
    function onScanSuccess(decodedText, decodedResult) {
        html5QrcodeScanner.clear().then(() => {
            ejecutarBusqueda(decodedText);
        }).catch(err => {
            ejecutarBusqueda(decodedText);
        });
    }

    function buscarManual() {
        const ean = document.getElementById('ean_manual').value;
        if (ean.length < 8) {
            alert("Por favor, introduce un código válido.");
            return;
        }
        ejecutarBusqueda(ean);
    }

    function ejecutarBusqueda(ean) {
    const resDiv = document.getElementById('resultado');
    const errDiv = document.getElementById('contenedor_error');
    
    if(resDiv) {
        resDiv.style.display = 'block';
        resDiv.innerText = "Buscando código: " + ean;
    }
    if(errDiv) errDiv.style.display = 'none';

    // Añadimos el header 'Accept: application/json'
    fetch(`/buscar-producto/${ean}`, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) throw new Error('No encontrado');
        return response.json();
    })
    .then(data => {
        if (data.url) {
            window.location.href = data.url; // Ahora sí redirige el navegador
        }
    })
    .catch(err => {
        if(resDiv) resDiv.style.display = 'none';
        if(errDiv) errDiv.style.display = 'block';
    });
    }

    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", { 
            fps: 10, 
            qrbox: {width: 250, height: 150},
            rememberLastUsedCamera: true
        }
    );
    html5QrcodeScanner.render(onScanSuccess);

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

        const mapeoBotones = {
            'html5-qrcode-button-camera-start': "Iniciar Cámara",
            'html5-qrcode-button-camera-stop': "Detener Cámara",
            'html5-qrcode-button-camera-permission': "Conceder Permiso",
            'html5-qrcode-button-file-selection': "Elegir Imagen"
        };

        Object.keys(mapeoBotones).forEach(id => {
            const btn = document.getElementById(id);
            if (btn && btn.innerText !== mapeoBotones[id]) {
                btn.innerText = mapeoBotones[id];
            }
        });

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

    setInterval(traducirEscaner, 500);
</script>
@endsection