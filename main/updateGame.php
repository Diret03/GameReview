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
    <link rel="stylesheet" href="../css/app.css">
    <link rel="stylesheet" href="../css/form.css">

    <style>
        body::before {
            background-image: linear-gradient(115deg,
                    rgba(58, 58, 158, 0.8),
                    rgba(136, 136, 206, 0.7)),
                /*fondo de pantalla*/
                url(https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/a3bf6b4c-9a4e-4d58-a3a7-ae498c536802/da30brv-48dbf45d-fe55-4d41-ad5f-721958e2003a.jpg/v1/fill/w_1166,h_685,q_70,strp/playstation_buttons_by_mojojojolabs_da30brv-pre.jpg?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7ImhlaWdodCI6Ijw9NzUyIiwicGF0aCI6IlwvZlwvYTNiZjZiNGMtOWE0ZS00ZDU4LWEzYTctYWU0OThjNTM2ODAyXC9kYTMwYnJ2LTQ4ZGJmNDVkLWZlNTUtNGQ0MS1hZDVmLTcyMTk1OGUyMDAzYS5qcGciLCJ3aWR0aCI6Ijw9MTI4MCJ9XV0sImF1ZCI6WyJ1cm46c2VydmljZTppbWFnZS5vcGVyYXRpb25zIl19._gsLhp9CwrfYAkN86HCH9aUY8qyX0ugjRP2w4WuvzUs);
        }
    </style>
</head>

<body>
    <div class="container">
        <header class="header">
            <h1 id="title" class="text-center">Actualizar videojuego</h1>
        </header>
        <form method="POST" enctype="multipart/form-data" id="survey-form">
            <div class="form-group">
                <label for="name">Nombre:</label>
                <input type="text" class="form-control" id="name" name="name" required value="<?php echo $name; ?>">
            </div>
            <div class="form-group">
                <label for="description">Descripción:</label>
                <textarea class="form-control input-textarea" id="description" name="description" required><?php echo $description; ?></textarea>
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
            <div class="form-group">
                <button type="submit" id="submit" name="submit" class="submit-button">
                    Actualizar videojuego
                </button>
            </div>
        </form>
        <button type="submit" class="submit-button">
            <a href="../main/games.php">Regresar</a>
        </button>
    </div>

</body>

</html>