@extends('layouts.app')

@section("title","- Escanear Producto")

@section('content')
<div class="container text-center pb-5">
    <h2 class="mb-4 fw-bold">Escanear Código de Barras</h2>
    
    <div id="reader" class="shadow-sm rounded-4 overflow-hidden border" style="width: 100%; max-width: 500px; margin: auto;"></div>
    
    <div id="resultado" class="mt-3 alert alert-info" style="display:none;">
        Buscando producto...
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
                   oninput="this.value = this.value.replace(/[^0-9]/g, '')"> <button class="btn btn-danger px-4 fw-bold" type="button" onclick="buscarManual()">
                BUSCAR
            </button>
        </div>
        <div id="error_manual" class="text-danger small mt-2 fw-bold" style="display:none;">
            El producto no existe.
        </div>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode"></script>

<script>
    // 1. Lógica del Escáner (La que ya tenías)
    function onScanSuccess(decodedText, decodedResult) {
        html5QrcodeScanner.clear();
        ejecutarBusqueda(decodedText);
    }

    // 2. Lógica del Buscador Manual
    function buscarManual() {
        const ean = document.getElementById('ean_manual').value;
        if (ean.length < 8) {
            alert("Por favor, introduce un código válido.");
            return;
        }
        ejecutarBusqueda(ean);
    }

    // 3. Función común de búsqueda para no repetir código
    function ejecutarBusqueda(ean) {
        document.getElementById('resultado').style.display = 'block';
        document.getElementById('resultado').innerText = "Buscando código: " + ean;
        document.getElementById('error_manual').style.display = 'none';

        fetch(`/buscar-producto/${ean}`)
            .then(response => {
                if (!response.ok) throw new Error('No encontrado');
                return response.json();
            })
            .then(data => {
                if (data.url) {
                    window.location.href = data.url;
                }
            })
            .catch(err => {
                document.getElementById('resultado').style.display = 'none';
                document.getElementById('error_manual').style.display = 'block';
                console.error("Error:", err);
            });
    }

    // Configuración del escáner
    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", { fps: 10, qrbox: {width: 250, height: 150} }
    );
    html5QrcodeScanner.render(onScanSuccess);
</script>
@endsection