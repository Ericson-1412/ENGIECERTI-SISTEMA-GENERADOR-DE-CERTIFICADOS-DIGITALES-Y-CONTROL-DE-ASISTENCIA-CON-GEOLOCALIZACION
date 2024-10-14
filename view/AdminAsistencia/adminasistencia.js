var usu_id = $('#usu_idx').val();

function init() {
    $("#asistencia_form").on("submit", function(e) {
        guardaryeditar(e);
    });
}

function guardaryeditar(e) {
    e.preventDefault();
    var formData = new FormData($("#asistencia_form")[0]);
    $.ajax({
        url: "../../controller/asistencia.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(data) {
            $('#cursos_data').DataTable().ajax.reload();
            $("#modalmantenimiento").modal('hide');

            Swal.fire({
                title: 'Correcto!',
                text: 'Se Registro Correctamente',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            });
        }
    });
}


function editar(id_asistencia) {
    $.post("../../controller/asistencia.php?op=mostrar", { id_asistencia: id_asistencia }, function (data) {
        data = JSON.parse(data);
        console.log(data);
        $('#id_asistencia').val(data.id_asistencia);  // ID de la asistencia
        $('#usu_id').val(data.usu_id);                // ID del usuario
        $('#fecha').val(data.fecha);                  // Fecha de la asistencia
        $('#hora').val(data.hora);                    // Hora de la asistencia
        $('#latitud').val(data.latitud);              // Latitud
        $('#longitud').val(data.longitud);            // Longitud
        // Si la foto está almacenada, podrías mostrarla de esta manera:
        $('#preview_foto').attr('src', '../public/fotos_asistencia/' + data.foto);
    });
    $('#lbltitulo').html('Editar Asistencia');
    $("#modalmantenimiento").modal('show');
}


$(document).ready(function() {

    // Capturar la imagen cuando se presiona el botón
    $("#capture-button").click(function (e) {
        e.preventDefault();  // Evita que el formulario se envíe
        const canvasContext = $("canvas")[0].getContext("2d");
        canvasContext.drawImage($("video")[0], 0, 0, 320, 240);
        const dataUrl = $("canvas")[0].toDataURL("image/png");

        // Ahora, puedes manejar la imagen capturada
        console.log("Foto capturada:", dataUrl);
    });

    $.post("../../controller/asistencia.php?op=combo", function (data) {
        $('#usu_id').html(data);
    });

    $('#usu_id').change(function() {
        var usu_id = $(this).val(); // Obtener el valor del usuario seleccionado

        $('#asistencia_data').DataTable({
            "aProcessing": true,
            "aServerSide": true,
            "ajax": {
                url: "../../controller/asistencia.php?op=listar",
                type: "post",
                data: { usu_id: usu_id }, // Enviar el ID del usuario al backend
            },
            "bDestroy": true,
            "responsive": true,
            "bInfo": true,
            "iDisplayLength": 10,
            "order": [[ 0, "desc" ]],
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sSearch": "Buscar:",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            },
        });
    });
});

function editar(id_asistencia) {
    $.post("../../controller/asistencia.php?op=mostrar", { id_asistencia: id_asistencia }, function (data) {
        data = JSON.parse(data);
        console.log(data);
        $('#id_asistencia').val(data.id_asistencia);
        $('#usu_id').val(data.usu_id); // ID del usuario
        $('#fecha').val(data.fecha); // Fecha de asistencia
        $('#foto').val(data.foto); // Foto (puedes ajustar si se trata de mostrar una imagen)
        $('#latitud').val(data.latitud); // Latitud de la ubicación
        $('#longitud').val(data.longitud); // Longitud de la ubicación
    });
    $('#lbltitulo').html('Editar Asistencia');
    $("#modalmantenimiento").modal('show');
}

function eliminar(id_asistencia) {
    swal.fire({
        title: "Eliminar!",
        text: "¿Desea eliminar el registro de asistencia?",
        icon: "error",
        confirmButtonText: "Sí",
        showCancelButton: true,
        cancelButtonText: "No",
    }).then((result) => {
        if (result.value) {
            $.post("../../controller/asistencia.php?op=eliminar", { id_asistencia: id_asistencia }, function (data) {
                $("#asistencia_data").DataTable().ajax.reload(); // Recargar la tabla de asistencia

                Swal.fire({
                    title: 'Correcto!',
                    text: 'Se eliminó la asistencia correctamente',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                });
            });
        }
    });
}

function nuevo() {
    $('#lbltitulo').html('Nuevo Registro de Asistencia');
    $("#asistencia_form")[0].reset(); // Limpiar el formulario
    $(".editar-only").hide(); // Ocultar los campos de edición
    $("#modalmantenimiento").modal('show'); // Mostrar el modal
}

init();
