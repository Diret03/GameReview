<?php
// reviews.php

// Database credentials
$hostnameDB = 'localhost';
$usernameDB = 'root';
$passwordDB = '';
$databaseDB = 'gamereview';
$portDB = '3306';

// Create a new MySQLi instance
$conn = new mysqli($hostnameDB, $usernameDB, $passwordDB, $databaseDB, $portDB);

// Check the connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Obtener el ID del juego desde la URL
if (isset($_GET['gameID'])) {
    $gameID = $_GET['gameID'];

    // Consultar las reseñas del juego desde la base de datos
    $query = "SELECT review.*, users.username
              FROM review
              INNER JOIN users ON review.userID = users.userID
              WHERE review.gameID = ?";
    $statement = $conn->prepare($query);
    $statement->bind_param('i', $gameID);
    $statement->execute();
    $result = $statement->get_result();
    $resenas = $result->fetch_all(MYSQLI_ASSOC);
} else {
    // Si no se proporciona un ID válido, redireccionar al usuario a la página principal u otra página de error.
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/forms.css">
    <title>Reseñas del Videojuego</title>
</head>

<body>
    <div class="container py-5">
        <h1>Reseñas del Juego</h1>
        <?php if (empty($resenas)): ?>
            <div class="alert alert-warning">
                Aún no hay reseñas de este juego :(
            </div>
        <?php else: ?>
            <?php foreach ($resenas as $resena): ?>
                <div class="card mb-3">
                    <div class="card-header">
                        Calificación:
                        <?php echo $resena['rating']; ?>/5
                    </div>
                    <div class="card-body">
                        <p class="card-text user-text">
                            Usuario:
                            <?php echo $resena['username']; ?><br>
                            Comentario:
                            <?php echo $resena['comment']; ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>

</html>