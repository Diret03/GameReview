<?php
// Incluye el archivo de conexión a la base de datos (db.php)
include '../php/db.php';

// Consulta para obtener los datos de la tabla de videojuegos
$sql = "SELECT * FROM games";
$result = mysqli_query($con, $sql);

// Verifica si se obtuvieron resultados
// if (mysqli_num_rows($result) > 0) {
//     $videojuegos = array();
//     while ($row = mysqli_fetch_assoc($result)) {
//         $videojuegos[] = $row;
//     }
//     // Devuelve los datos en formato JSON
//     echo json_encode($videojuegos);
// } else {
//     echo "No se encontraron videojuegos.";
// }

if ($result) {

    while ($row = mysqli_fetch_assoc($result)) {

        $gameID = $row['gameID'];
        $name = $row['name'];
        $description = $row['description'];
        $releaseDate = $row['releaseDate'];
        $genre = $row['genre'];
        $developer = $row['developer'];

        $tablaHTML = '';
        $tablaHTML .= '<tr>';
        $tablaHTML .= '<td>' . $gameID . '</td>';
        $tablaHTML .= '<td>' . $name . '</td>';
        // $tablaHTML .= '<td>' . $description . '</td>';
        $tablaHTML .= '<td>';
        $tablaHTML .= '<button class="btn btn-primary btn-descripcion" data-toggle="collapse" data-target="#descripcion-' . $gameID . '">
        <i class="fas fa-plus"></i>
        </button>';
        $tablaHTML .= '<div id="descripcion-' . $gameID . '" class="collapse">' . $description . '</div>';
        $tablaHTML .= '</td>';
        $tablaHTML .= '<td>' . $releaseDate . '</td>';
        $tablaHTML .= '<td>' . $genre . '</td>';
        $tablaHTML .= '<td>' . $developer . '</td>';
        $tablaHTML .= '<td>' .
            '       
            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
            <div class="btn-group mr-2" role="group" aria-label="Actualizar y Eliminar">

                <button type="button" class="btn btn-primary">
                <a class="fas fa-sync-alt text-light" href="../main/updateGame.php?updateid=' . $gameID . '"></a>
            </button>
                <button type="button" class="btn btn-danger">
                <a class="fas fa-trash-alt text-light" href="../main/deleteGame.php?deleteid=' . $gameID . '"></a>
            </button>
            </div>
        </div>'
            . '</td>';
        // $tablaHTML += '<td><button class="btn btn-danger btn-sm btn-eliminar" data-id="' + videojuego.gameID + '">X</button></td>';
        // tablaHTML += '<td><img src="' + videojuego.imagen + '" alt="Imagen del videojuego" width="100"></td>';
        $tablaHTML .= '</tr>';

        echo $tablaHTML;
    }
}
