<?php
include '../php/db.php';

$userID = $_GET['updateid'];

$sql = "SELECT * FROM users WHERE userID=$userID";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

$userID = $row['userID'];
$username = $row['username'];
$email = $row['email'];
$password = $row['password'];
$type = $row['type'];

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $type = $_POST['type'];

    $sql = "UPDATE users SET username='$username', email='$email', password='$password', type='$type' WHERE userID=$userID";

    // Ejecutamos la consulta
    $result = mysqli_query($con, $sql);

    if ($result) {
        header('location: ../main/users.php');
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
    <title>Añadir Nuevo Videojuego</title>
    <link rel="stylesheet" href="../css/app.css">
    <link rel="stylesheet" href="../css/form.css">

    <style>
        body::before {
            background-image: linear-gradient(115deg,
                    rgba(58, 58, 158, 0.8),
                    rgba(136, 136, 206, 0.7)),
                /*fondo de pantalla*/
                url(https://cdn.wallpapersafari.com/99/8/cyBOTY.jpg);
        }
    </style>
</head>

<body>
    <div class="container">
        <header class="header">
            <h1 id="title" class="text-center">Actualizar usuario</h1>
        </header>
        <form method="POST" enctype="multipart/form-data" id="survey-form">
            <div class="form-group">
                <label for="username">Nombre de usuario:</label>
                <input type="text" class="form-control" id="username" name="username" required value="<?php echo $username; ?>">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required value="<?php echo $email; ?>"></input>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" class="form-control" id="password" name="password" required value="<?php echo $password; ?>">
            </div>
            <div class="form-group">
                <label for="type">Tipo:</label>
                <input type="number" class="form-control" id="type" name="type" min="0" max="1" required value="<?php echo $type; ?>">
            </div>
            <div class="form-group">
                <button type="submit" id="submit" name="submit" class="submit-button">
                    Actualizar usuario
                </button>
            </div>
        </form>
        <button type="submit" class="submit-button">
            <a href="../main/users.php">Regresar</a>
        </button>
    </div>

</body>

</html>