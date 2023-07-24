<?php
include '../php/db.php';

// Función para obtener el nombre del usuario a partir de su userID
function getUsername($userID)
{
    global $con;
    $sql = "SELECT username FROM users WHERE userID=$userID";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['username'];
}

function getGameName($gameID)
{
    global $con;
    $sql = "SELECT name FROM games WHERE gameID=$gameID";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['name'];
}

$sql = "SELECT * FROM review";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reseñas de Videojuegos</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/app.css">

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Virtual Verdicts</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="../main/index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../main/games.php">Videojuegos</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="../main/crudReview.php">Reseñas<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../main/account.php">Cuenta</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-4">
        <h1 class="mb-4">Reseñas de Videojuegos</h1>
        <button class="btn btn-primary">
            <a href="../main/addReview.php" class="text-light">Agregar reseña</a>
        </button>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario(ID)</th>
                    <th>Título del Videojuego(ID)</th>
                    <th>Calificación</th>
                    <th>Comentario</th>
                </tr>
            </thead>
            <tbody id="tabla-resenas">
                <?php
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $reviewID = $row['reviewID'];
                        $userID = $row['userID'];
                        $gameID = $row['gameID'];
                        $rating = $row['rating'];
                        $comment = $row['comment'];

                        $tablaHTML = '';
                        $tablaHTML .= '<tr>';
                        $tablaHTML .= '<td>' . $reviewID . '</td>';
                        $tablaHTML .= '<td>' . getUsername($userID) . '(' . $userID . ')' . '</td>';
                        $tablaHTML .= '<td>' . getGameName($gameID) . '(' . $gameID . ')' . '</td>';
                        $tablaHTML .= '<td>' . $rating . '/5</td>';
                        $tablaHTML .= '<td>';
                        $tablaHTML .= '<button class="btn btn-primary btn-comment" data-toggle="collapse" data-target="#comentario-' . $reviewID . '">
                            <i class="fas fa-plus"></i>
                            </button>';
                        $tablaHTML .= '<div id="comentario-' . $reviewID . '" class="collapse">' . $comment . '</div>';
                        $tablaHTML .= '</td>';
                        $tablaHTML .= '<td>' .
                            '       
                            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                            <div class="btn-group mr-2" role="group" aria-label="Actualizar y Eliminar">
                
                                <button type="button" class="btn btn-primary">
                                <a class="fas fa-sync-alt text-light" href="../main/updateReview.php?updateid=' . $reviewID . '"></a>
                            </button>
                                <button type="button" class="btn btn-danger">
                                <a class="fas fa-trash-alt text-light" href="../main/deleteReview.php?deleteid=' . $reviewID . '"></a>
                            </button>
                            </div>
                        </div>'
                            . '</td>';
                        $tablaHTML .= '</tr>';
                        echo $tablaHTML;
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="../js/desplegar.js"></script>
</body>

</html>