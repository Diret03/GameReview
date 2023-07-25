<?php


include '../php/db.php';

session_start();
$userID = $_SESSION['userID'];
$sqlUser = "SELECT type FROM users WHERE userID='$userID'";
$resultUser = mysqli_query($con, $sqlUser);
$user = mysqli_fetch_assoc($resultUser);

if (isset($_GET['deleteid'])) {

    $reviewID = $_GET['deleteid'];

    $sql1 = "DELETE FROM review WHERE reviewID=$reviewID";
    $result1 = mysqli_query($con, $sql1);

    if ($result1) {

        if ($user['type'] == 0) {
            // Redirigir a account.php si es cliente
            header('location: account.php');
            die();
        } elseif ($user['type'] == 1) {
            // Redirigir a crudReview.php si es administrador
            header('location: crudReview.php');
            die();
        }
    } else {
        die(mysqli_error($con));
    }
}
