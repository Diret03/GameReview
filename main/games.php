<?php

include '../php/db.php';

//pasos para comprobar que es un admin y no cliente....
session_start();

$userID = $_SESSION['userID'];

$sqlUser = "SELECT type FROM users WHERE userID='$userID'";
$resultUser = mysqli_query($con, $sqlUser);
$user = mysqli_fetch_assoc($resultUser);

if (!isset($_SESSION["userID"]) || $user['type'] != 1) {
    // Si el usuario no ha iniciado sesión o no es un cliente, redirige a la página de inicio de sesión
    header('Location: login.php');
    exit();
}

// Función para obtener el nombre del genero a partir de su genderID
function getGenreName($genreID)
{
    global $con;
    $sql = "SELECT genreName FROM genres WHERE genreID =$genreID";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['genreName'];
}

// Cantidad de filas a mostrar por página
$rowsPerPage = 10;

if (isset($_GET['search'])) {
    $searchTerm = mysqli_real_escape_string($con, $_GET['search']);

    // Consulta para buscar videojuegos que coincidan con el título, desarrolladora o género
    $sqlSearch = "SELECT games.*, genres.genreName
    FROM games
    LEFT JOIN genres ON games.genreID = genres.genreID
    WHERE games.name LIKE '%$searchTerm%'
    OR games.developer LIKE '%$searchTerm%'
    OR genres.genreName LIKE '%$searchTerm%'";
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

    // Consulta para obtener las filas de videojuegos de la búsqueda actual
    $sqlGamesPage = $sqlSearch . " LIMIT $start, $rowsPerPage";
    $resultGamesPage = mysqli_query($con, $sqlGamesPage);
} else {
    // Si no se realizó una búsqueda, mostrar todos los videojuegos paginados como antes
    $sqlTotalRows = "SELECT COUNT(*) AS totalRows FROM games";
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
    $sqlGamesPage = "SELECT * FROM games LIMIT $start, $rowsPerPage";
    $resultGamesPage = mysqli_query($con, $sqlGamesPage);
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
                <a href="../main/games.php" class="active">Videojuegos</a>
                <a href="../main/crudReview.php">Reseñas</a>
                <a href="../main/users.php">Usuarios</a>
                <a href="../main/genres.php">Géneros</a>
                <a href="../main/changepassword.php">Cambiar Contraseña</a>
                <a href="../php/logout.php">Cerrar Sesión</a>
            </nav>

            <!-- Contenido principal -->
            <main class="col-md-10 main-content">
                <h1 class="mb-4">Videojuegos</h1>
                <div id="form-container">
                    <button class="btn btn-primary" id="btnAdd">
                        <a href="../main/addGame.php" class="text-light">Agregar videojuego</a>
                    </button>
                    <form class="form-inline" method="GET">
                        <input class="form-control mr-sm-2" type="search" name="search" placeholder="Buscar videojuego">
                        <button class="btn btn-primary my-2 my-sm-0" type="submit">Buscar</button>
                    </form>
                </div>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Fecha de Lanzamiento</th>
                            <th>Género</th>
                            <th>Desarrolladora</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-videojuegos">
                        <?php
                        include '../php/db.php';
                        if (mysqli_num_rows($resultGamesPage) > 0) {
                            while ($row = mysqli_fetch_assoc($resultGamesPage)) {
                                // Obtener los datos del videojuego
                                $gameID = $row['gameID'];
                                $name = $row['name'];
                                $description = $row['description'];
                                $releaseDate = $row['releaseDate'];
                                $genreID = $row['genreID'];
                                $developer = $row['developer'];

                                // Generar la fila de la tabla para el videojuego actual
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
                                $tablaHTML .= '<td>' . getGenreName($genreID) . '</td>';
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
                                $tablaHTML .= '</tr>';
                                echo $tablaHTML;
                            }
                        } else {
                            echo '<td colspan="6" class="alert alert-info" role="alert">
                                    <p class="text-center">No se encontró ningún videojuego.</p>                           
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

            <script src="../js/desplegarGame.js"></script>
        </div>
    </div>

</body>

</html>