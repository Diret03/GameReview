<?php
include '../php/db.php';

//pasos para obtener nombre de usuario...
session_start();
// Obtener el ID del usuario actual desde la sesión
$userID = $_SESSION['userID'];

$sqlUser = "SELECT type FROM users WHERE userID='$userID'";
$resultUser = mysqli_query($con, $sqlUser);
$user = mysqli_fetch_assoc($resultUser);

$sql = "SELECT * FROM review WHERE userID = '$userID'";
$result = mysqli_query($con, $sql);

function getUsername($userID)
{
    global $con;
    $sql = "SELECT username FROM users WHERE userID=$userID";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['username'];
}

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Obtener la nueva contraseña y confirmar contraseña del formulario
    $newPassword = $_POST["newPassword"];
    $confirmPassword = $_POST["confirmPassword"];

    // Verificar si las contraseñas coinciden
    if ($newPassword !== $confirmPassword) {
        $error_message = "Las contraseñas no coinciden.";
    } else {
        // Validar la nueva contraseña según tus requisitos de seguridad
        // Puedes agregar tus propias reglas de validación aquí


        $sql = "UPDATE users SET password='$newPassword' WHERE userID=$userID";

        $result = mysqli_query($con, $sql);

        if ($result) {
            // Contraseña actualizada exitosamente
            if ($user['type'] == 0) {
                // Redirigir a account.php si es cliente
                header('location: account.php');
                die();
            } elseif ($user['type'] == 1) {
                // Redirigir a crudReview.php si es administrador
                header('location: dashboard.php');
                die();
            }
        } else {
            // Ocurrió un error al actualizar la contraseña
            $error_message = "Ocurrió un error al cambiar la contraseña. Inténtalo de nuevo más tarde.";
        }
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
    <link rel="stylesheet" href="../css/app.css">
</head>

<body>

    <section class="vh-100" style="background-color: #eee;">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-5">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                    <p class="text-center h1 fw-bold mt-4">Cambiar Contraseña</p>

                                    <p class="text-center mb-4"><?php echo getUsername($userID); ?></p> <!-- Mostrar nombre de usuario -->


                                    <?php if (isset($error_message)) : ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?php echo $error_message; ?> <!-- Mostrar mensaje de error si las contraseñas no coinciden -->
                                        </div>
                                    <?php endif; ?>
                                    <form class="mx-1 mx-md-4" method="POST">

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <label for="newPassword">Nueva Contraseña:</label>
                                                <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <label for="confirmPassword">Cambiar Contraseña:</label>
                                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <button type="submit" name="submit" class="btn btn-primary">Cambiar Contraseña</button>
                                        </div>
                                    </form>
                                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                        <a href="../main/account.php">Regresar</a>
                                    </div>
                                </div>
                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                                    <img src="https://admin.registeredemail.com/uploads/2021/02/honeypot-hackers-twitter-heats.png" class="img-fluid" alt="Sample image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>