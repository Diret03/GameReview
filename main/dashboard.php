<?php


include '../php/db.php';

//pasos para comprobar que ha iniciado sesion y es admin....
session_start();

$userID = $_SESSION['userID'];

$sqlUser = "SELECT type FROM users WHERE userID='$userID'";
$resultUser = mysqli_query($con, $sqlUser);
$user = mysqli_fetch_assoc($resultUser);

if (!isset($_SESSION["userID"]) || $user['type'] != 1) {
    // Si el usuario no ha iniciado sesión o no es un cliente, redirige a la página de inicio de sesión
    header('Location: login.php');
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard del Administrador</title>
    <!-- Importa el archivo bootstrap.min.css o usa el enlace a Bootstrap desde un CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="../css/app.css">
    <link rel="stylesheet" href="../css/dashboard.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Panel lateral (sidebar) -->
            <nav class="col-md-2 sidebar">
                <h3 class="text-center">Dashboard</h3>
                <a href="../main/dashboard.php" class=" active">Inicio</a>
                <a href="../main/games.php">Videojuegos</a>
                <a href="../main/crudReview.php">Reseñas</a>
                <a href="../main/users.php">Usuarios</a>
                <a href="../main/genres.php">Géneros</a>
                <a href="../main/changepassword.php">Cambiar Contraseña</a>
                <a href="../php/logout.php">Cerrar Sesión</a>
            </nav>

            <!-- Contenido principal -->
            <main class="col-md-10 main-content">
                <h1 class="text-center">Dashboard del Administrador</h1>
                <p class="lead text-center">Aquí podrás administrar los videojuegos y reseñas del sitio.</p>
                <!-- Contenido de las secciones de videojuegos, reseñas, etc. -->
                <img src="../img/admin.png" alt="Admin">
            </main>
        </div>
    </div>

    <!-- Importa los archivos de JavaScript de Bootstrap (jQuery y Popper.js) desde CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
</body>

</html>