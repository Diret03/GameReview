<?php
include '../php/db.php';

// Cantidad de filas a mostrar por página
$rowsPerPage = 10;

if (isset($_GET['search'])) {
    $searchTerm = mysqli_real_escape_string($con, $_GET['search']);

    // Consulta para buscar reseñas que coincidan con el calificación, comentario, reviewID, nombre del juego o nombre de usuario
    $sqlSearch = "SELECT review.*, users.username, games.name AS gameName
                  FROM review
                  LEFT JOIN users ON review.userID = users.userID
                  LEFT JOIN games ON review.gameID = games.gameID
                  WHERE review.reviewID LIKE '%$searchTerm%'
                  OR review.rating LIKE '%$searchTerm%'
                  OR review.comment LIKE '%$searchTerm%'
                  OR users.username LIKE '%$searchTerm%'
                  OR games.name LIKE '%$searchTerm%'";

    $resultSearch = mysqli_query($con, $sqlSearch);

    // Obtener el número total de filas en la búsqueda
    $sqlTotalRowsSearch = "SELECT COUNT(*) AS totalRows FROM ($sqlSearch) AS searchResults";
    $resultTotalRowsSearch = mysqli_query($con, $sqlTotalRowsSearch);
    $rowTotalRowsSearch = mysqli_fetch_assoc($resultTotalRowsSearch);
    $totalRows = $rowTotalRowsSearch['totalRows'];

    // Calcular el número total de páginas
    $totalPages = ceil($totalRows / $rowsPerPage);

    // Obtener la página actual (si no está definida, será 1 por defecto)
    $currentPage = isset($_GET['page']) ? max(1, $_GET['page']) : 1;

    // Calcular el índice de inicio y fin de las filas a mostrar en la página actual
    $start = ($currentPage - 1) * $rowsPerPage;
    $end = min($start + $rowsPerPage - 1, $totalRows - 1);

    // Consulta para obtener las filas de reseñas de la búsqueda actual
    $sqlReviewsPage = $sqlSearch . " LIMIT $start, $rowsPerPage";
    $resultReviewsPage = mysqli_query($con, $sqlReviewsPage);
} else {
    // Si no se realizó una búsqueda, mostrar todos las reseñas paginadas como antes
    $sqlTotalRows = "SELECT COUNT(*) AS totalRows FROM review";
    $resultTotalRows = mysqli_query($con, $sqlTotalRows);
    $rowTotalRows = mysqli_fetch_assoc($resultTotalRows);
    $totalRows = $rowTotalRows['totalRows'];

    // Calcular el número total de páginas
    $totalPages = ceil($totalRows / $rowsPerPage);

    // Obtener la página actual (si no está definida, será 1 por defecto)
    $currentPage = isset($_GET['page']) ? max(1, $_GET['page']) : 1;

    // Calcular el índice de inicio y fin de las filas a mostrar en la página actual
    $start = ($currentPage - 1) * $rowsPerPage;
    $end = min($start + $rowsPerPage - 1, $totalRows - 1);

    // Consulta para obtener las filas de videojuegos de la página actual
    $sqlReviewsPage = "SELECT * FROM review LIMIT $start, $rowsPerPage";
    $resultReviewsPage = mysqli_query($con, $sqlReviewsPage);
}
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
                <a href="../main/users.php">Usuarios</a>
                <a href="../main/genres.php">Géneros</a>
                <a href="../main/changepassword.php">Cambiar Contraseña</a>
                <a href="../php/logout.php">Cerrar Sesión</a>
            </nav>

            <!-- Contenido principal -->
            <main class="col-md-10 main-content">
                <h1 class="mb-4">Reseñas de Videojuegos</h1>
                <div id="form-container">
                    <form class="form-inline" method="GET">
                        <input class="form-control mr-sm-2" type="search" name="search" placeholder="Buscar reseña">
                        <button class="btn btn-primary my-2 my-sm-0" type="submit">Buscar</button>
                    </form>
                </div>
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

                        if (mysqli_num_rows($resultReviewsPage) > 0) {
                            while ($row = mysqli_fetch_assoc($resultReviewsPage)) {
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
                        } else {
                            echo '<td colspan="6" class="alert alert-info" role="alert">
                                    <p class="text-center">No se encontró ninguna reseña.</p>                           
                                  </td>';
                        }

                        ?>
                    </tbody>
                </table>
                <nav class="mt-4" aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <?php
                        // Mostrar botones de flechas para navegar entre las páginas de videojuegos
                        if ($currentPage > 1) {
                            echo '<li class="page-item"><a class="page-link" href="?page=' . ($currentPage - 1) . '">Anterior</a></li>';
                        }

                        for ($i = 1; $i <= $totalPages; $i++) {
                            $activeClass = ($i === $currentPage) ? 'active' : '';
                            echo '<li class="page-item ' . $activeClass . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                        }

                        if ($currentPage < $totalPages) {
                            echo '<li class="page-item"><a class="page-link" href="?page=' . ($currentPage + 1) . '">Siguiente</a></li>';
                        }
                        ?>
                    </ul>
                </nav>
            </main>

        </div>
    </div>

    <script src="../js/desplegarCrudComment.js"></script>

</body>

</html>