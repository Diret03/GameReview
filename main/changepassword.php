<?php
session_start();

// Obtener el nombre de usuario del usuario actual
include '../php/db.php';
$userID = $_SESSION['userID'];

$sql = "SELECT username FROM users WHERE userID=$userID";
$result = mysqli_query($con, $sql);
$user = mysqli_fetch_assoc($result);

// Al precionar el boton cambie la contraseña
if (isset($_POST['change']) && !empty($_POST['nueva_contrasena']) && !empty($_POST['confirmar_contrasena'])) {
    $nuevaContrasena = $_POST['nueva_contrasena'];
    $confirmarContrasena = $_POST['confirmar_contrasena'];

    // Verificar que las contraseñas coincidan
    if ($nuevaContrasena === $confirmarContrasena) {
        $updateSql = "UPDATE users SET password='$nuevaContrasena' WHERE userID=$userID";

        if (mysqli_query($con, $updateSql)) {
            echo '<script>alert("Contraseña Cambiada Exitosamente");</script>';
        } else {
            echo '<script>alert("no se puede cambiar la contraseña");</script>';
        }
    } else {
        echo '<script>alert("No coinciden intentelo nuevamente");</script>';
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('https://ergo2play.com/cdn/shop/articles/M314_1080x.jpg?v=1633105598');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        .btn-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .btn-container .btn {
            border: none;
            margin: 10px;
            font-size: 12px;
            padding: 20px 40px;
            height: 50px;
            width: 200px;
            background: linear-gradient(to right, #030126, #06dea4);
        }
        h1, label{
            color: white;
        }
        form{
            background-color:blue: #007bff;
            backdrop-filter: blur(10px); 
        }
    </style>
</head>

<body>
        <form action="" method="POST">
        <div class="btn-container">
        <h1 class="text-center mb-5">Cambio de contraseña, <?php echo $user['username']; ?>!</h1>
        <form method="POST">
            <section>
                <label for="nueva_contrasena">Nueva contraseña:</label>
                <input class="form-control" type="password" id="nueva_contrasena" name="nueva_contrasena" required>
                <label for="confirmar_contrasena">Confirmar nueva contraseña:</label>
                <input class="form-control" type="password" id="confirmar_contrasena" name="confirmar_contrasena" required>
            </section>
            <button type="submit" name="change" class="btn btn-primary">Cambiar Contraseña</button>
        </form>
    </div>
        </form>
    
</body>

</html>