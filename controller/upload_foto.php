<?php
$uploadDirectory = '../public/fotos_asistencia/'; // Asegúrate de que esta ruta sea correcta

if (isset($_FILES['capturedImage']) && !empty($_FILES['capturedImage']['tmp_name'])) {
    $uploadedFile = $_FILES['capturedImage']['tmp_name'];

    // Generar un nombre único para la imagen
    $extension = pathinfo($_FILES['capturedImage']['name'], PATHINFO_EXTENSION);
    $newFileName = uniqid() . '.' . $extension;
    $destination = $uploadDirectory . $newFileName;

    if (move_uploaded_file($uploadedFile, $destination)) {
        echo 'Imagen subida exitosamente: ' . $newFileName;  // Aquí puedes devolver el nombre de la imagen
    } else {
        echo 'Error al mover la imagen al directorio de destino.';
    }
} else {
    echo 'No se recibió ninguna imagen.';
}
?>