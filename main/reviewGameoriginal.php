<?php

include '../php/db.php';

// Verificar si el usuario ha iniciado sesión
session_start();
if (!isset($_SESSION['userID'])) {
    // Si el usuario no ha iniciado sesión, redirigirlo a la página de inicio de sesión
    header('location: login.php');
    die();
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
    $genre = $row['genre'];
    $developer = $row['developer'];
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reseñar Videojuego</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4 my-5">
        <h1>Reseñar Videojuego: <?php echo $name; ?></h1>
        <p><b>Género:</b> <?php echo $genre; ?></p>
        <p><b>Desarrolladora:</b> <?php echo $developer; ?></p>
        <p><b>Fecha de Lanzamiento:</b> <?php echo $releaseDate; ?></p>
        <p><?php echo $description; ?></p>

        <form method="POST">
            <div class="form-group">
                <label for="content">Reseña:</label>
                <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="rating">Calificación:</label>
                <input type="number" class="form-control" id="rating" name="rating" required min="1" max="5">
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Enviar Reseña</button>
        </form>
        <button type="button" class="btn btn-primary" style="margin-top: 2px;">
            <a class="text-light" href="../main/index.php">Regresar</a>
        </button>
    </div>

</body>

</html>