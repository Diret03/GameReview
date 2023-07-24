<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reseñas de Videojuegos</title>
    <!-- Importa el archivo bootstrap.min.css o usa el enlace a Bootstrap desde un CDN -->
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
                <li class="nav-item active">
                    <a class="nav-link" href="#">Videojuegos<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../main/crudReview.php">Reseñas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../main/account.php">Cuenta</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-4">
        <h1 class="mb-4">Videojuegos</h1>
        <button class="btn btn-primary">
            <a href="../main/addGame.php" class="text-light">Agregar videojuego</a>
        </button>
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
                $sql = "SELECT * FROM games";
                $result = mysqli_query($con, $sql);

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