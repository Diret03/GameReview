<?php
// Incluir el archivo de conexión a la base de datos
include '../php/db.php';
// Obtener el ID de la reseña a actualizar desde la URL
$reviewID = $_GET['updateid'];



// Obtener los datos de la reseña de la base de datos
$sql = "SELECT * FROM review WHERE reviewID=$reviewID";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

// Asignar los valores a las variables correspondientes
$reviewID = $row['reviewID'];
$gameID = $row['gameID'];
$rating = $row['rating'];
$comment = $row['comment'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $rating = $_POST['rating'];
    $comment = mysqli_real_escape_string($con, $_POST['comment']);

    // Preparar y ejecutar la consulta SQL para actualizar la reseña
    $sql = "UPDATE review SET rating=?, comment=? WHERE reviewID=?";
    $stmt = mysqli_prepare($con, $sql);

    if ($stmt) {
        // Bindear los valores a la sentencia
        mysqli_stmt_bind_param($stmt, "isi", $rating, $comment, $reviewID);

        // Ejecutar la sentencia
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            header('location: account.php');
            die();
        } else {
            die(mysqli_error($con));
        }

        // Cerrar la sentencia
        mysqli_stmt_close($stmt);
    }
}

// Consultar el nombre del videojuego asociado a la reseña
$sql_game = "SELECT name FROM games WHERE gameID=$gameID";
$result_game = mysqli_query($con, $sql_game);
$row_game = mysqli_fetch_assoc($result_game);
$gameName = $row_game['name'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Reseña</title>
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
            <h1 id="title" class="text-center">Actualizar Reseña <br><?php echo $gameName; ?></h1>

        </header>
        <form method="POST" id="review-form">
            <div class="form-group">
                <label for="rating">Calificación:</label>
                <input type="number" class="form-control" id="rating" name="rating" min="1" max="5" required value="<?php echo $rating; ?>">
            </div>
            <div class="form-group">
                <label for="comment">Comentario:</label>
                <textarea class="form-control input-textarea" id="comment" name="comment" required><?php echo $comment; ?></textarea>
            </div>
            <div class="form-group">
                <button type="submit" id="submit" name="submit" class="submit-button">
                    Actualizar Reseña
                </button>
            </div>
        </form>
        <button type="submit" class="submit-button">
            <a href="../main/account.php">Regresar</a>
        </button>
    </div>

</body>

</html>