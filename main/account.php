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
// Mostrar el formulario para cambiar la contraseña
if (isset($_POST['change_password'])) {
    header('location: changepassword.php');
    die();
}


//Obtener el correo del usuario
$sql1 = "SELECT email FROM users WHERE userID=$userID";
$result1 = mysqli_query($con, $sql1);
$user1 = mysqli_fetch_assoc($result1);


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
            background-image: url('https://i.pinimg.com/originals/62/dd/dd/62dddd03bab522af0b94fa33fa1fa45d.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            backdrop-filter: blur(8px);
        }

        .btn-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        h1, label{
            color: white;
        }
        .btn-container .btn {
            border:none;
            margin: 40px;
            font-size: 14px;
            padding: 20px 40px;
            background: -webkit-linear-gradient(to right,#00de55, #4800ff);
            background: linear-gradient(to right, #000000, #de0696);
        }
    </style>
</head>

<body>

    <div class="btn-container">
        <h1 class="text-center mb-5">Bienvenido!</h1>
        <div class="form-outline flex-fill mb-0">
        <label for="username">Nombre Usuario:</label>
        <label for="username"> <?php echo $user['username']; ?></label>
        <br>
        <label for="useremail">Correo Electronico:</label>
        <label for="useremail"> <?php echo $user1['email']; ?></label>
        
        </div>
        <form method="POST">
            <button type="submit" name="change_password" class="btn btn-primary">Cambiar Contraseña</button>
            <button type="submit" name="logout" class="btn btn-danger">Cerrar Sesión</button>
        </form>
    </div>
</body>

</html>