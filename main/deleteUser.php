<?php

include '../php/db.php';

if (isset($_GET['deleteid'])) {
    $userID = $_GET['deleteid'];

    // Eliminar registros relacionados en la tabla 'review'
    $sqlDeleteReviews = "DELETE FROM review WHERE userID=$userID";
    $resultDeleteReviews = mysqli_query($con, $sqlDeleteReviews);

    if (!$resultDeleteReviews) {
        die(mysqli_error($con));
    }

    // Ahora que los registros relacionados en la tabla 'review' han sido eliminados,
    // se elimina el usuario de la tabla 'users'
    $sqlDeleteUser = "DELETE FROM users WHERE userID=$userID";
    $resultDeleteUser = mysqli_query($con, $sqlDeleteUser);

    if ($resultDeleteUser) {
        header('location: ../main/users.php');
        die();
    } else {
        die(mysqli_error($con));
    }
}
