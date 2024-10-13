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