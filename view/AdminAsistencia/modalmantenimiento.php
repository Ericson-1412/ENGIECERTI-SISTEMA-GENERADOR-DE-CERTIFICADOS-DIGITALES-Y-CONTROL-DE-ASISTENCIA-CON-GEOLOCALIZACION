<div id="modalmantenimiento" class="modal fade" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content bd-0">
            <div class="modal-header pd-y-20 pd-x-25">
                <h6 id="lbltitulo" class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Nuevo Registro</h6>
            </div>
            <form method="post" id="asistencia_form">
                <div class="modal-body pd-25">
                    <input type="hidden" name="id_asistencia" id="id_asistencia" />
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="fecha">Fecha: *</label>
                                <input class="form-control" id="fecha" type="date" name="fecha" required />
                            </div>
                        </div>

                        <!-- Añadir un margen en la parte superior para separar la sección de la cámara -->
                        <div class="form-group mt-4">
                            <label>Capturar Foto:</label>
                            <div class="d-flex justify-content-between align-items-center">
                                <!-- Botón de captura alineado a la izquierda -->
                                <button id="capture-button" class="btn btn-primary">Tomar Foto</button>
                                
                                <!-- Espacio de video a la derecha con margen izquierdo para separación -->
                                <div class="ml-4">
                                    <video autoplay width="320" height="240"></video>
                                    <canvas style="display:none;"></canvas> <!-- Canvas oculto para capturar la foto -->
                                </div>
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

<script>
    const video = document.querySelector('video');
    const captureButton = document.querySelector('#capture-button');
    const canvas = document.querySelector('canvas');
    const context = canvas.getContext('2d');

    // Solicitar acceso a la cámara
    navigator.mediaDevices.getUserMedia({ video: true })
        .then(stream => {
            video.srcObject = stream;
        })
        .catch(error => {
            console.error('Error al acceder a la cámara: ', error);
        });

    // Capturar la imagen cuando se presiona el botón
    captureButton.addEventListener('click', function() {
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        const dataUrl = canvas.toDataURL('image/png');

        // Aquí puedes enviar la imagen capturada al servidor
        console.log('Foto capturada: ', dataUrl);
    });
</script>