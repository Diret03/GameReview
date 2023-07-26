<?php

include '../php/db.php';

// Obtener los géneros de la tabla "genres"
$sqlGenres = "SELECT * FROM genres";
$resultGenres = mysqli_query($con, $sqlGenres);

// Crear un arreglo para almacenar los géneros
$genres = array();

while ($rowGenre = mysqli_fetch_assoc($resultGenres)) {
    $genres[$rowGenre['genreID']] = $rowGenre['genreName'];
}

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
    $sql = "INSERT INTO games (name, description, releaseDate, genreID, developer, image) VALUES (?, ?, ?, ?, ?, ?)";

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
            <h1 id="title" class="text-center">Añadir videojuego</h1>
        </header>
        <form method="POST" enctype="multipart/form-data" id="survey-form">
            <div class="form-group">
                <label for="name" id="name-label">Nombre:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Descripción:</label>
                <textarea class="form-control input-textarea" id="description" name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="releaseDate">Fecha de Lanzamiento:</label>
                <input type="date" class="form-control" id="releaseDate" name="releaseDate" required>
            </div>
            <div class="form-group">
                <label for="genre">Género:</label>
                <select id="genre" name="genre" class="form-control" required>
                    <option disabled selected value="">Seleccionar género</option>
                    <?php foreach ($genres as $genreID => $genreName) { ?>
                        <option value="<?php echo $genreID; ?>"><?php echo $genreName; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="developer">Desarrolladora:</label>
                <input type="text" class="form-control" id="developer" name="developer" required>
            </div>
            <div class="form-group">
                <label for="image">Imagen:</label>
                <input type="file" class="form-control-file" id="image" name="image" accept="image/*" required>
            </div>
            <div class="form-group">
                <button type="submit" id="submit" name="submit" class="submit-button">
                    Agregar
                </button>
            </div>
        </form>
        <button type="submit" class="submit-button">
            <a href="../main/games.php">Regresar</a>
        </button>
    </div>
</body>

</html>