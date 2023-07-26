<?php

include '../php/db.php';

if (isset($_GET['deleteid'])) {
    $genreID = $_GET['deleteid'];


    $sql = "DELETE FROM genres where genreID=$genreID";
    $result = mysqli_query($con, $sql);

    if ($result) {
        header('location: ../main/genres.php');
        die();
    } else {
        die(mysqli_error($con));
    }
}
