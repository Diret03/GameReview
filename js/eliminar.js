// DESCARTADO

$(document).ready(function () {
    // Agregar el evento de clic para los botones de eliminar
    $('.btn-eliminar').click(function () {
        var videojuegoID = $(this).data('id');
        // Llamar a la función para eliminar el videojuego
        eliminarVideojuego(videojuegoID);
    });
});

// Función para eliminar el videojuego mediante AJAX
function eliminarVideojuego(videojuegoID) {
    $.ajax({
        url: '../php/deleteGame.php',
        type: 'POST',
        data: { videojuegoID: videojuegoID },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                // Realizar alguna acción después de eliminar el videojuego (por ejemplo, recargar la tabla)
                alert(response.message);
            } else {
                alert('Error al eliminar el videojuego.');
            }
        },
        error: function () {
            alert('Error al eliminar el videojuego.');
        }
    });
}
