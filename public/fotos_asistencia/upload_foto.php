<?php
if (isset($_POST['foto'])) {
    $data = $_POST['foto'];

    // Quitar el encabezado de los datos base64
    list($type, $data) = explode(';', $data);
    list(, $data) = explode(',', $data);

    // Decodificar la imagen
    $data = base64_decode($data);

    // Guardar la imagen en la carpeta fotos_asistencia
    $filePath = '../../public/fotos_asistencia/foto_' . time() . '.png'; // Cambiamos la ruta aquí
    file_put_contents($filePath, $data);

    echo json_encode(['success' => true, 'path' => $filePath]);
}
?>