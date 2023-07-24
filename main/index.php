<?php
// Código PHP para obtener los detalles de los videojuegos desde la base de datos
include '../php/db.php';

// Cantidad de juegos a mostrar por página
$gamesPerPage = 6;

// Obtener el número total de juegos
$sqlTotal = "SELECT COUNT(*) AS total FROM games";
$resultTotal = mysqli_query($con, $sqlTotal);
$rowTotal = mysqli_fetch_assoc($resultTotal);
$totalGames = $rowTotal['total'];

// Calcular el número total de páginas
$totalPages = ceil($totalGames / $gamesPerPage);

// Obtener la página actual (si no está definida, será 1 por defecto)
$currentPage = isset($_GET['page']) ? max(1, $_GET['page']) : 1;

// Calcular el índice de inicio y fin de los juegos a mostrar en la página actual
$start = ($currentPage - 1) * $gamesPerPage;
$end = min($start + $gamesPerPage - 1, $totalGames - 1);

// Consulta para obtener los juegos de la página actual
$sql = "SELECT * FROM games LIMIT $start, $gamesPerPage";
$result = mysqli_query($con, $sql);

function getAverage($gameID)
{
    global $con;
    $sql = "SELECT AVG(rating) AS average FROM review WHERE gameID=$gameID";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

    // Obtener el promedio de calificación, redondeado a un decimal
    $promedio = round($row['average'], 1);

    return $promedio;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/app.css">
    <title>Inicio</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Virtual Verdicts</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Inicio<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../main/games.php">Videojuegos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../main/crudReview.php">Reseñas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../main/account.php">Cuenta</a>
                </li>
            </ul>
        </div>
        <style>
            /* Estilo para que todas las imágenes tengan el mismo tamaño */
            .card-img-top {
                height: 420px;
                object-fit: cover;
            }
        </style>
    </nav>
    <section style="background-color: #eee;">
        <div class="container py-5">
            <?php
            $count = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                if ($count % 3 === 0) {
                    echo '<div class="row">';
                }

                // Aquí obtén los valores específicos del videojuego desde la fila actual en $row
                $gameID = $row['gameID'];
                $name = $row['name'];
                $genre = $row['genre'];
                $releaseDate = $row['releaseDate'];
                $developer = $row['developer'];

                if (getAverage($gameID) == 0) {
                    $calificacion = '-/5';
                } else
                    $calificacion = getAverage($gameID) . '/5'; // Esto debe reemplazarse por la calificación real del videojuego

                // Convertir el BLOB de la imagen en una URL válida (esquema data URI)
                $imageData = $row['image'];
                $base64Image = base64_encode($imageData);
                $imageURL = 'data:image/jpeg;base64,' . $base64Image;

                echo '
                <div class="col-md-12 col-lg-4 mb-4 mb-lg-0">
                    <div class="card">
                        <div class="d-flex justify-content-between p-3">
                            <h4 class="mb-0">' . $name . '</h4>
                        </div>
                        <img src="' . $imageURL . '" class="card-img-top" />
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <p class="small"><a href="#!" class="text-muted">' . $genre . '</a></p>
                                <p class="small text-danger">' . $releaseDate . '</p>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <h5 class="mb-0">' . $developer . '</h5>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <a class="text-muted mb-0" href="../main/reviews.php?displayreviewid=' . $gameID . '">Calificación: ' . $calificacion . '</a>
                                <button type="button" class="btn btn-primary">
                                <a class="fas fa-sync-alt text-light" href="../main/reviewGame.php?reviewid=' . $gameID . '">Reseñar</a>
                            </div>
                        </div>
                    </div>
                </div>
                ';

                $count++;

                if ($count % 3 === 0) {
                    echo '</div>';
                }
            }

            // Si el número total de videojuegos no es múltiplo de 3, cierra la última fila con </div>
            if ($count % 3 !== 0) {
                echo '</div>';
            }
            ?>
        </div>
    </section>

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
    <footer class="bg-light text-center text-lg-start">
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            <!-- Footer -->
        </div>
    </footer>
</body>

</html>