<?php

// Conectar a la base de datos
include '../php/db.php';
session_start();

$userID = $_SESSION['userID'];

// Obtener el tipo de usuario (0 para cliente, 1 para administrador)
$sql = "SELECT type FROM users WHERE userID='$userID'";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);

    if ($user['type'] == 0) {
        // Redirigir a account.php si es cliente
        header('location: ../main/account.php');
        die();
    } elseif ($user['type'] == 1) {
        // Redirigir a dashboard.php si es administrador
        header('location: ../main/dashboard.php');
        die();
    }
}
