<?php

include '../php/db.php';
$gameID = $_GET['updateid'];

$sql = "SELECT * FROM games WHERE gameID=$gameID";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

$gameID = $row['gameID'];
$name = $row['name'];
$description = $row['description'];
$releaseDate = $row['releaseDate'];
$genre = $row['genre'];
$developer = $row['developer'];

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $releaseDate = $_POST['releaseDate'];
    $genre = $_POST['genre'];
    $developer = $_POST['developer'];

    // Verificamos si se ha cargado una nueva imagen
    if (!empty($_FILES['image']['tmp_name'])) {
        // Obtenemos la nueva imagen cargada en el formulario
        $newImage = $_FILES['image']['tmp_name'];

        // Convertimos la nueva imagen a formato binario para almacenarla en la base de datos
        $newImageData = file_get_contents($newImage);

        // Preparamos la consulta SQL para actualizar el juego con la nueva imagen
        $sql = "UPDATE games SET name=?, description=?, releaseDate=?, genre=?, developer=?, image=? WHERE gameID=?";
        $stmt = mysqli_prepare($con, $sql);

        if ($stmt) {
            // Bindeamos los valores a la sentencia
            mysqli_stmt_bind_param($stmt, "ssssssi", $name, $description, $releaseDate, $genre, $developer, $newImageData, $gameID);
        }
    } else {
        // Si no se cargó una nueva imagen, actualizamos el juego sin modificar la imagen
        $sql = "UPDATE games SET name=?, description=?, releaseDate=?, genre=?, developer=? WHERE gameID=?";
        $stmt = mysqli_prepare($con, $sql);

        if ($stmt) {
            // Bindeamos los valores a la sentencia
            mysqli_stmt_bind_param($stmt, "sssssi", $name, $description, $releaseDate, $genre, $developer, $gameID);
        }
    }

    // Ejecutamos la sentencia
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        header('location: games.php');
        die();
    } else {
        die(mysqli_error($con));
    }

    // Cerramos la sentencia
    mysqli_stmt_close($stmt);
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Nuevo Videojuego</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4 my-5">
        <h1>Actualizar videojuego</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Nombre:</label>
                <input type="text" class="form-control" id="name" name="name" required value="<?php echo $name; ?>">
            </div>
            <div class="form-group">
                <label for="description">Descripción:</label>
                <textarea class="form-control" id="description" name="description" rows="5" required><?php echo $description; ?></textarea>
            </div>
            <div class="form-group">
                <label for="releaseDate">Fecha de Lanzamiento:</label>
                <input type="date" class="form-control" id="releaseDate" name="releaseDate" required value="<?php echo $releaseDate; ?>">
            </div>
            <div class="form-group">
                <label for="genre">Género:</label>
                <input type="text" class="form-control" id="genre" name="genre" required value="<?php echo $genre; ?>">
            </div>
            <div class="form-group">
                <label for="developer">Desarrolladora:</label>
                <input type="text" class="form-control" id="developer" name="developer" required value="<?php echo $developer; ?>">
            </div>
            <div class="form-group">
                <label for="image">Imagen:</label>
                <input type="file" class="form-control-file" id="image" name="image" accept="image/*" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Actualizar</button>
        </form>
        <button type="submit" name="submit" class="btn btn-primary" style="margin-top: 2px;"><a class="text-light" href="../main/games.php">Regresar</a></button>
    </div>

</body>

</html>