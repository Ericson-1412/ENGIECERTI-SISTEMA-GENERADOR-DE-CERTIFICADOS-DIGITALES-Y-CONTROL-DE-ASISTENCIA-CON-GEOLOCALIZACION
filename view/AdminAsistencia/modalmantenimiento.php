<div id="modalmantenimiento" class="modal fade" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content bd-0">
            <div class="modal-header pd-y-20 pd-x-25">
                <h6 id="lbltitulo" class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Nuevo Registro</h6>
            </div>
            <form method="post" id="asistencia_form" enctype="multipart/form-data">
                <div class="modal-body pd-25">
                    <input type="hidden" name="id_asistencia" id="id_asistencia" />
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="fecha">Fecha: *</label>
                                <input class="form-control" id="fecha" type="date" name="fecha" required />
                            </div>
                        </div>
                        <br>
                        <div class="col-md-12 center">
                            <video id="theVideo" autoplay muted></video>
                            <canvas id="theCanvas"></canvas> <!-- Mantener oculto el canvas -->
                        </div>
                        <div class="d-grid gap-2 d-md-block">
                            <button type="button" class="btn btn-primary" id="btnCapture">Tomar foto</button>
                            <button type="button" class="btn btn-primary" id="btnDownloadImage" disabled>Descargar Imagen</button>
                            <button type="button" class="btn btn-primary" id="btnSendImageToServer" disabled>Guardar Imagen</button>
                            <button type="button" class="btn btn-primary" id="btnStartCamera">Iniciar Cámara</button>          
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="hora">Hora:</label>
                                <input class="form-control" id="hora" name="hora" readonly>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="latitud">Latitud:</label>
                                <input class="form-control" id="latitud" name="latitud" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="longitud">Longitud:</label>
                                <input class="form-control" id="longitud" name="longitud" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="action" value="add" class="btn btn-outline-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">
                        <i class="fa fa-check"></i> Guardar
                    </button>
                    <button type="button" class="btn btn-outline-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" 
                            aria-label="Close" aria-hidden="true" data-dismiss="modal">
                        <i class="fa fa-close"></i> Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    const videoWidth = 420;
    const videoHeight = 320;
    const videoTag = document.getElementById("theVideo");
    const canvasTag = document.getElementById("theCanvas");
    const btnCapture = document.getElementById("btnCapture");
    const btnDownloadImage = document.getElementById("btnDownloadImage");
    const btnSendImageToServer = document.getElementById("btnSendImageToServer");
    const btnStartCamera = document.getElementById("btnStartCamera");

    let cameraActive = false; // Variable para rastrear el estado de la cámara

    // Establecer estado inicial de los botones
    btnCapture.disabled = true;
    btnDownloadImage.disabled = true;
    btnSendImageToServer.disabled = true;

    // Configurar los atributos de video y canvas
    videoTag.setAttribute("width", videoWidth);
    videoTag.setAttribute("height", videoHeight);
    canvasTag.setAttribute("width", videoWidth);
    canvasTag.setAttribute("height", videoHeight);

    // Evento para iniciar la cámara
    btnStartCamera.addEventListener("click", async () => {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({
                audio: false,
                video: { width: videoWidth, height: videoHeight },
            });
            videoTag.srcObject = stream;
            btnStartCamera.disabled = true;

            // Habilitar el botón de captura cuando la cámara esté activa
            cameraActive = true;
            btnCapture.disabled = false;
        } catch (error) {
            console.log("Error al iniciar la cámara:", error);
        }
    });

    // Evento para capturar la imagen y obtener la ubicación
    btnCapture.addEventListener("click", () => {
    const canvasContext = canvasTag.getContext("2d");
    canvasContext.drawImage(videoTag, 0, 0, videoWidth, videoHeight);
    btnDownloadImage.disabled = false;
    btnSendImageToServer.disabled = false;

    // Obtener la ubicación cuando se captura la imagen
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;

            // Mostrar las coordenadas en los campos
            document.getElementById("latitud").value = lat;
            document.getElementById("longitud").value = lon;
        }, function (error) {
            console.error("Error al obtener la ubicación:", error);
        });
    } else {
        alert("Geolocalización no soportada por este navegador.");
    }

    // Obtener la hora actual y rellenar el campo
    const now = new Date();
    const currentTime = now.toTimeString().split(" ")[0]; // Obtener solo la hora (HH:mm:ss)
    document.getElementById("hora").value = currentTime;
    
    });
    // Botón para forzar la descarga de la imagen
    btnDownloadImage.addEventListener("click", () => {
        const link = document.createElement("a");
        link.download = "capturedImage.png";
        link.href = canvasTag.toDataURL();
        link.click();
    });

    btnSendImageToServer.addEventListener("click", async () => {
    const dataURL = canvasTag.toDataURL(); // Tomar la imagen del canvas
    const blob = await dataURLtoBlob(dataURL); // Convertir la imagen a Blob
    const data = new FormData();
    data.append("capturedImage", blob, "capturedImage.png"); // Enviar la imagen como 'capturedImage'

    try {
        const response = await axios.post("../../controller/upload_foto.php", data, {
            headers: { "Content-Type": "multipart/form-data" },
        });
        alert(response.data); // Mensaje de éxito o error del servidor
    } catch (error) {
        console.error("Error al enviar la imagen:", error);
    }
});
    // Función para convertir dataURL a Blob
    async function dataURLtoBlob(dataURL) {
        const arr = dataURL.split(",");
        const mime = arr[0].match(/:(.*?);/)[1];
        const bstr = atob(arr[1]);
        const n = bstr.length;
        const u8arr = new Uint8Array(n);
        for (let i = 0; i < n; i++) {
            u8arr[i] = bstr.charCodeAt(i);
        }
        return new Blob([u8arr], { type: mime });
    }
</script>