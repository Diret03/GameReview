// DESCARTADO

$(document).ready(function () {
    // Realiza una solicitud AJAX para obtener los datos de videojuegos
    $.ajax({
        url: '../php/display.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            if (data.length > 0) {
                // Genera el contenido de la tabla
                var tablaHTML = '';
                $.each(data, function (index, videojuego) {

                    // Trunca la descripción si es más larga que 50 caracteres
                    const descripcion = videojuego.description.length > 50 ? videojuego.description.substr(0, 50) + '...' : videojuego.description;

                    tablaHTML += '<tr>';
                    tablaHTML += '<td>' + videojuego.gameID + '</td>';
                    tablaHTML += '<td>' + videojuego.name + '</td>';
                    tablaHTML += '<td>' + descripcion + '</td>';
                    tablaHTML += '<td>' + videojuego.releaseDate + '</td>';
                    tablaHTML += '<td>' + videojuego.genre + '</td>';
                    tablaHTML += '<td>' + videojuego.developer + '</td>';
                    tablaHTML += '<td><button class="btn btn-danger btn-sm btn-eliminar" data-id="' + videojuego.gameID + '">X</button></td>';
                    // tablaHTML += '<td><img src="' + videojuego.imagen + '" alt="Imagen del videojuego" width="100"></td>';
                    tablaHTML += '</tr>';
                });
                // Agrega el contenido a la tabla
                $('#tabla-videojuegos').html(tablaHTML);
            } else {
                // Si no se encontraron datos, muestra un mensaje en la tabla
                $('#tabla-videojuegos').html('<tr><td colspan="6">No se encontraron videojuegos.</td></tr>');
            }
        },
        error: function () {
            // Si ocurre un error, muestra un mensaje en la tabla
            $('#tabla-videojuegos').html('<tr><td colspan="6">Error al obtener los datos de videojuegos.</td></tr>');
        }
    });
});