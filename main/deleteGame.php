<?php

include '../php/db.php';

if (isset($_GET['deleteid'])) {

    $gameID = $_GET['deleteid'];

    $sql = "DELETE FROM games WHERE gameID=$gameID";

    $result = mysqli_query($con, $sql);


    if ($result) {
        header('location: index.php');
        die();
    } else {
        die(mysqli_error($con));
    }
}
