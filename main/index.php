<?php
// Código PHP para obtener los detalles de los videojuegos desde la base de datos
include '../php/db.php';
$sql = "SELECT * FROM games";
$result = mysqli_query($con, $sql);
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
        <a class="navbar-brand" href="#">Videojuegos</a>
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
                $calificacion = '5/5'; // Esto debe reemplazarse por la calificación real del videojuego

                // Convertir el BLOB de la imagen en una URL válida (esquema data URI)
                $imageData = $row['image'];
                $base64Image = base64_encode($imageData);
                $imageURL = 'data:image/jpeg;base64,' . $base64Image;

                echo '
                <div class="col-md-12 col-lg-4 mb-4 mb-lg-0">
                    <div class="card">
                        <div class="d-flex justify-content-between p-3">
                            <h5 class="mb-0">' . $name . '</h5>
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
                                <p class="text-muted mb-0">Calificación: ' . $calificacion . '</p>
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
    <footer class="bg-light text-center text-lg-start">
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            <!-- Footer -->
        </div>
    </footer>
</body>

</html>