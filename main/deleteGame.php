<?php


include '../php/db.php';

if (isset($_GET['deleteid'])) {

    $gameID = $_GET['deleteid'];

    // Eliminar registros relacionados en la tabla 'review'
    $sqlDeleteReviews = "DELETE FROM review WHERE gameID=$gameID";
    $resultDeleteReviews = mysqli_query($con, $sqlDeleteReviews);

    if (!$resultDeleteReviews) {
        die(mysqli_error($con));
    }

    // Ahora que los registros relacionados en la tabla 'review' han sido eliminados,
    // procedemos a eliminar el juego de la tabla 'games'
    $sqlDeleteGame = "DELETE FROM games WHERE gameID=$gameID";
    $resultDeleteGame = mysqli_query($con, $sqlDeleteGame);

    if ($resultDeleteGame) {
        header('location: games.php');
        die();
    } else {
        die(mysqli_error($con));
    }
}
