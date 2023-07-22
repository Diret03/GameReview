<?php

include '../php/db.php';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $description = mysqli_real_escape_string($con, $_POST['description']); //se manejan caracteres especiales
    $releaseDate = $_POST['releaseDate'];
    $genre = $_POST['genre'];
    $developer = $_POST['developer'];

    // Obtenemos la imagen cargada en el formulario
    $image = $_FILES['image']['tmp_name'];

    // Convertimos la imagen a formato binario para almacenarla en la base de datos
    if ($image) {
        $imageData = file_get_contents($image);
    } else {
        // Si no se cargó ninguna imagen, puedes asignar un valor por defecto o mostrar un mensaje de error
        die("Error: Debes seleccionar una imagen");
    }

    // Preparamos la consulta SQL con el marcador de posición para el valor binario de la imagen
    $sql = "INSERT INTO games (name, description, releaseDate, genre, developer, image) VALUES (?, ?, ?, ?, ?, ?)";

    // Preparamos la sentencia y verificamos si se realizó correctamente
    $stmt = mysqli_prepare($con, $sql);

    if ($stmt) {
        // Bindeamos los valores a la sentencia
        mysqli_stmt_bind_param($stmt, "ssssss", $name, $description, $releaseDate, $genre, $developer, $imageData);

        // Ejecutamos la sentencia
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            header('location: games.php');
            die();
        } else {
            // echo "Error al ingresar";
            // // die(mysqli_error($con));
            die(mysqli_error($con));
        }

        // Cerramos la sentencia
        mysqli_stmt_close($stmt);
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
    <title>Añadir videojuego</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4 my-5">
        <h1>Añadir videojuego</h1>
        <form method="POST" enctype="multipart/form-data">
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
            <div class="form-group">
                <label for="image">Imagen:</label>
                <input type="file" class="form-control-file" id="image" name="image" accept="image/*" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Agregar</button>

        </form>
        <button type="submit" name="submit" class="btn btn-primary" style="margin-top: 2px;"><a class="text-light" href="../main/games.php">Regresar</a></button>
    </div>

</body>

</html>