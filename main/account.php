<?php
// Verificar si el usuario ha iniciado sesión
session_start();
if (!isset($_SESSION['userID'])) {
    // Si no ha iniciado sesión, redirigirlo a la página de inicio de sesión
    header('location: login.php');
    die();
}

// Obtener el ID del usuario actual desde la sesión
$userID = $_SESSION['userID'];

// Conectar a la base de datos
include '../php/db.php';

// Obtener las reseñas del usuario actual desde la base de datos
$sql = "SELECT * FROM review WHERE userID = '$userID'";
$result = mysqli_query($con, $sql);

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

// Verificar si el usuario ha hecho clic en el botón de cerrar sesión
if (isset($_GET['logout'])) {
    // Destruir todas las variables de sesión
    session_destroy();

    // Redirigir al usuario a la página de inicio de sesión
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuenta</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="stylesheet" href="../css/app.css">
    <link rel="stylesheet" href="../css/account.css">
    <link rel="stylesheet" href="../css/index.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light" id="barraInicio">
        <a class="navbar-brand">Virtual Verdicts</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="../main/index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../main/account.php">Cuenta</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mb-4 main-container">
        <div class="row">
            <div class="col-lg-4 pb-5">
                <!-- Account Sidebar-->
                <div class="author-card pb-3">
                    <div class="author-card-cover" style="background-image: url(https://c4.wallpaperflare.com/wallpaper/71/905/253/pixel-art-trixel-super-mario-mushroom-wallpaper-preview.jpg);">
                    </div>
                    <div class="author-card-profile">
                        <div class="author-card-avatar"><img src="../img/profile.png">
                        </div>
                        <div class="author-card-details">
                            <h3 id="username"><?php echo getUsername($userID); ?></h3> <!-- nombre de usuario (username) -->

                        </div>
                    </div>
                </div>
                <div class="wizard">
                    <nav class="list-group list-group-flush">
                        <a class="list-group-item" href="../main/changepassword.php"><i class="fa fa-user text-muted"></i>Cambiar Contraseña</a>

                        <!--  se implementa el parámetro logout a la URL del sitio al darle  click a "Cerrar Sesion"-->
                        <a class="list-group-item" href="?logout=1"><i class="fa fa-user text-muted"></i>Cerrar Sesión</a>
                    </nav>
                </div>
            </div>

            <div class="col-lg-8 pb-5">
                <h3 class="mb-4">Historial de reseñas</h3>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Título del Videojuego</th>
                                <th>Calificación</th>
                                <th>Comentario</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-resenas">
                            <?php
                            // Recorrer los resultados de la consulta y mostrar las reseñas en la tabla
                            if ($result) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $reviewID = $row['reviewID'];
                                    $gameID = $row['gameID'];
                                    $rating = $row['rating'];
                                    $comment = $row['comment'];

                                    // Obtener el título del videojuego por ID (reemplaza 'getGameTitle' con la función correcta)
                                    $gameTitle = getGameName($gameID);

                                    // Generar la fila de la tabla con los datos de la reseña
                                    // Generar la fila de la tabla con los datos de la reseña
                                    echo '<tr>';
                                    echo '<td>' . $gameTitle . '</td>';
                                    echo '<td>' . $rating . '/5</td>';
                                    echo '<td>';
                                    echo '<button class="btn btn-primary btn-comment" data-toggle="collapse" data-target="#comentario-' . $reviewID . '">';
                                    echo '<i class="fas fa-plus"></i>';
                                    echo '</button>';
                                    echo '<div id="comentario-' . $reviewID . '" class="collapse">' . $comment . '</div>';
                                    echo '</td>';
                                    echo '<td>' .
                                        '<div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
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
                                    echo '</tr>';
                                }
                            } else
                                echo '<tr><td colspan="3">No se encontraron reseñas.</td></tr>';
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/desplegarReview.js"></script>
</body>

</html>