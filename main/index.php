<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reseñas de Videojuegos</title>
    <!-- Importa el archivo bootstrap.min.css o usa el enlace a Bootstrap desde un CDN -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Videojuegos</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Inicio<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Reseñas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Cuenta</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container mt-4">
        <h1 class="mb-4">Videojuegos</h1>
        <button class="btn btn-primary">
            <a href="../main/addGame.php" class="text-light">Agregar videojuego</a>
        </button>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Fecha de Lanzamiento</th>
                    <th>Género</th>
                    <th>Desarrolladora</th>
                    <!-- <th>Imagen</th> -->
                </tr>
            </thead>
            <tbody id="tabla-videojuegos">
                <?php
                include '../php/display.php';
                ?>
            </tbody>
        </table>
    </div>
    <script>
        $(document).ready(function() {
            // Agregar el evento de clic para el botón de descripción
            $('.btn-descripcion').click(function() {
                var icon = $(this).find('i'); // Obtener el ícono del botón

                // Verificar si la descripción está oculta o visible
                if ($(this).attr('aria-expanded') === 'true') {
                    // Si la descripción está visible, cambiar el ícono a 'fa-plus'
                    icon.removeClass('fa-minus').addClass('fa-plus');
                } else {
                    // Si la descripción está oculta, cambiar el ícono a 'fa-minus'
                    icon.removeClass('fa-plus').addClass('fa-minus');
                }
            });

            // Agregar un evento para cuando se complete la animación de colapso/expandir
            $('.collapse').on('shown.bs.collapse hidden.bs.collapse', function() {
                var icon = $(this).prev('.btn-descripcion').find('i'); // Obtener el ícono del botón

                // Verificar si la descripción está oculta o visible
                if ($(this).hasClass('show')) {
                    // Si la descripción está visible, cambiar el ícono a 'fa-minus'
                    icon.removeClass('fa-plus').addClass('fa-minus');
                } else {
                    // Si la descripción está oculta, cambiar el ícono a 'fa-plus'
                    icon.removeClass('fa-minus').addClass('fa-plus');
                }
            });
        });
    </script>

</body>

</html>