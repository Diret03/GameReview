<?php

include '../php/db.php';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $description = mysqli_real_escape_string($con, $_POST['description']); //se manejan caracteres especiales
    $releaseDate = $_POST['releaseDate'];
    $genre = $_POST['genre'];
    $developer = $_POST['developer'];

    $sql = "INSERT INTO games (name,description,releaseDate,genre,developer) VALUES ('$name','$description','$releaseDate', '$genre', '$developer')";

    $result = mysqli_query($con, $sql);

    if ($result) {
        header('location: index.php');
        die();
    } else {
        // echo "Error al ingresar";
        // // die(mysqli_error($con));
        die(mysqli_error($con));
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir videojuego</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4 my-5">
        <h1>Añadir videojuego</h1>
        <form method="POST">
            <div class="form-group">
                <label for="name">Nombre:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Descripción:</label>
                <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="releaseDate">Fecha de Lanzamiento:</label>
                <input type="date" class="form-control" id="releaseDate" name="releaseDate" required>
            </div>
            <div class="form-group">
                <label for="genre">Género:</label>
                <input type="text" class="form-control" id="genre" name="genre" required>
            </div>
            <div class="form-group">
                <label for="developer">Desarrolladora:</label>
                <input type="text" class="form-control" id="developer" name="developer" required>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Agregar</button>

        </form>
        <button type="submit" name="submit" class="btn btn-primary" style="margin-top: 2px;"><a class="text-light" href="../main/index.php">Regresar</a></button>
    </div>

</body>

</html>