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
                <a href="../main/games.php" class=" active">Videojuegos</a>
                <a href="../main/crudReview.php">Reseñas</a>
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
                    <form class="form-inline">
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

            </main>
            <script src="../js/desplegarGame.js"></script>
        </div>
    </div>

</body>

</html>