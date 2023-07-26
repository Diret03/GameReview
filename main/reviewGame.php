<?php

include '../php/db.php';

// Verificar si el usuario ha iniciado sesión
session_start();
if (!isset($_SESSION['userID'])) {
    // Si el usuario no ha iniciado sesión, redirigirlo a la página de inicio de sesión
    header('location: login.php');
    die();
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

if (isset($_GET['reviewid'])) {
    $gameID = $_GET['reviewid'];

    // Verificar si se ha enviado el formulario de reseña
    if (isset($_POST['submit'])) {
        // Recopilar los datos del formulario
        $userID = $_SESSION['userID']; // Obtener el userID del usuario que ha iniciado sesión
        $content = mysqli_real_escape_string($con, $_POST['content']); // Se manejan caracteres especiales
        $rating = $_POST['rating'];

        // Insertar la reseña en la base de datos
        $sql = "INSERT INTO review (gameID, userID, comment, rating) VALUES ('$gameID', '$userID', '$content', '$rating')";
        $result = mysqli_query($con, $sql);

        if ($result) {
            // Redirigir a la página del juego después de agregar la reseña
            header('location: index.php');
            die();
        } else {
            die(mysqli_error($con));
        }
    }

    // Obtener los detalles del juego para mostrar en el formulario de reseña
    $sql = "SELECT * FROM games WHERE gameID=$gameID";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

    $name = $row['name'];
    $description = $row['description'];
    $releaseDate = $row['releaseDate'];
    $genreID = $row['genreID'];
    $developer = $row['developer'];
}
?>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/form.css">
</head>

<body>
    <div class="container">
        <header class="header">
            <h1 id="title" class="text-center">Reseñar Videojuego <br><?php echo $name; ?></h1>
            <p id="description" class="description text-center">
                <?php echo $description; ?>
            </p>
        </header>
        <form id="survey-form" method="POST">
            <p><b>Género: </b><?php echo getGenreName($genreID); ?></p>
            <p><b>Desarrolladora: </b> <?php echo $developer; ?></p>
            <p><b>Fecha de Lanzamiento: </b> <?php echo $releaseDate; ?></p>


            <div class="form-group">
                <label for="content">Reseña:</label>
                <textarea class="input-textarea" id="content" name="content" required></textarea>
            </div>

            <div class="form-group">
                <label id="number-label" for="rating">Calificación:</label>
                <input type="number" class="form-control" id="rating" name="rating" required min="1" max="5">
            </div>

            <div class="form-group">
                <button type="submit" id="submit" name="submit" class="submit-button">
                    Enviar Reseña
                </button>
            </div>
        </form>
        <button type="submit" class="submit-button">
            <a href="../main/index.php">Regresar</a>
        </button>
    </div>
</body>