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
    <link rel="stylesheet" href="../css/dashboard.css">

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Panel lateral (sidebar) -->
            <nav class="col-md-2 sidebar">
                <h3 class="text-center">Dashboard</h3>
                <a href="../main/dashboard.php">Inicio</a>
                <a href="../main/games.php">Videojuegos</a>
                <a href="../main/crudReview.php" class=" active">Reseñas</a>
                <a href="../main/changepassword.php">Cambiar Contraseña</a>
                <a href="../php/logout.php">Cerrar Sesión</a>
            </nav>

            <!-- Contenido principal -->
            <main class="col-md-10 main-content">
                <h1 class="mb-4">Reseñas de Videojuegos</h1>
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
                            <div class="btn-group mr-2" role="group" aria-label="Eliminar">
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

            </main>

        </div>
    </div>

    <script src="../js/desplegarCrudComment.js"></script>

</body>

</html>