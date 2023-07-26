<?php
include '../php/db.php';

$genreID = $_GET['updateid'];


$sql = "SELECT * FROM genres WHERE genreID=$genreID";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

$genreID = $row['genreID'];
$genreName = $row['genreName'];


if (isset($_POST['submit'])) {
    $genreName = $_POST['genreName'];

    $sql = "UPDATE genres SET genreName='$genreName' WHERE genreID=$genreID";

    // Ejecutamos la consulta
    $result = mysqli_query($con, $sql);

    if ($result) {
        header('location: ../main/genres.php');
        die();
    } else {
        die(mysqli_error($con));
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Nuevo Género de Videojuego</title>
    <link rel="stylesheet" href="../css/app.css">
    <link rel="stylesheet" href="../css/form.css">

    <style>
        body::before {
            background-image: linear-gradient(115deg,
                    rgba(58, 58, 158, 0.8),
                    rgba(136, 136, 206, 0.7)),
                /*fondo de pantalla*/
                url(https://wallpapercave.com/wp/wp6613504.jpg);
        }
    </style>
</head>

<body>
    <div class="container">
        <header class="header">
            <h1 id="title" class="text-center">Actualizar género de videojuego</h1>
        </header>
        <form method="POST" enctype="multipart/form-data" id="survey-form">
            <div class="form-group">
                <label for="genreName">Género:</label>
                <input type="text" class="form-control" name="genreName" value="<?php echo $genreName; ?>">
            </div>
            <div class="form-group">
                <button type="submit" id="submit" name="submit" class="submit-button">
                    Actualizar género
                </button>
            </div>
        </form>
        <button type="submit" class="submit-button">
            <a href="../main/genres.php">Regresar</a>
        </button>
    </div>

</body>

</html>