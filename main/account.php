<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['userID'])) {
    // Si no ha iniciado sesión, redirigirlo a la página de inicio de sesión
    header('location: login.php');
    die();
}

// Obtener el nombre de usuario del usuario actual
include '../php/db.php';
$userID = $_SESSION['userID'];
$sql = "SELECT username FROM users WHERE userID=$userID";
$result = mysqli_query($con, $sql);
$user = mysqli_fetch_assoc($result);

// Cerrar sesión al hacer clic en el botón
if (isset($_POST['logout'])) {
    session_destroy();
    header('location: login.php');
    die();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuenta</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .btn-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .btn-container .btn {
            margin: 10px;
            font-size: 24px;
            padding: 20px 40px;
        }
    </style>
</head>

<body>

    <div class="btn-container">
        <h1 class="text-center mb-5">Bienvenido, <?php echo $user['username']; ?>!</h1>
        <form method="POST">
            <button type="submit" name="change_password" class="btn btn-primary">Cambiar Contraseña</button>
            <button type="submit" name="logout" class="btn btn-danger">Cerrar Sesión</button>
        </form>
    </div>
</body>

</html>