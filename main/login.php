<?php
session_start();

if (isset($_SESSION['userID'])) {
    // Si el usuario ya ha iniciado sesión, redirigirlo a la página principal
    header('location: index.php');
    die();
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Conectar a la base de datos
    include '../php/db.php';

    // Verificar si el nombre de usuario está registrado
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verificar la contraseña
        if ($password === $user['password']) {
            // Iniciar sesión exitosamente
            $_SESSION['userID'] = $user['userID'];
            header('location: index.php');
            die();
        } else {
            $error_message = "Contraseña incorrecta. Por favor, intenta nuevamente.";
        }
    } else {
        $error_message = "El nombre de usuario no está registrado. Por favor, crea una cuenta.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
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

                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Iniciar Sesión</p>
                                    <?php if (isset($error_message)) : ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?php echo $error_message; ?>
                                        </div>
                                    <?php endif; ?>
                                    <form class="mx-1 mx-md-4" method="POST">

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <label for="username">Nombre de Usuario:</label>
                                                <input type="text" class="form-control" id="username" name="username" required>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <label for="password">Contraseña:</label>
                                                <input type="password" class="form-control" id="password" name="password" required>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <button type="submit" name="submit" class="btn btn-primary">Iniciar Sesión</button>
                                        </div>
                                    </form>
                                    <p>¿Aún no tienes una cuenta? <a href="signup.php">Regístrate aquí</a></p>

                                </div>
                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                                    <img src="https://icon-library.com/images/video-games-icon-png/video-games-icon-png-25.jpg" class="img-fluid" alt="Sample image">

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