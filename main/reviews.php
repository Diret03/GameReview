<?php
include '../php/db.php';

if (isset($_GET['displayreviewid'])) {
    $gameID = $_GET['displayreviewid'];

    // Obtener detalles del juego
    $sqlGame = "SELECT * FROM games WHERE gameID=$gameID";
    $resultGame = mysqli_query($con, $sqlGame);
    $rowGame = mysqli_fetch_assoc($resultGame);
    $gameName = $rowGame['name'];

    // Obtener las reseñas asociadas a este juego
    $sqlReviews = "SELECT * FROM review WHERE gameID=$gameID";
    $resultReviews = mysqli_query($con, $sqlReviews);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/app.css">
    <link rel="stylesheet" href="../css/review.css">
    <link rel="stylesheet" href="../css/index.css">
    <title>Reseñas de <?php echo $gameName; ?></title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light" id="barraInicio">
        <a class="navbar-brand" href="#">Virtual Verdicts</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="../main/index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../main/account.php">Cuenta</a>
                </li>
            </ul>
        </div>
    </nav>

    <section>
        <div class="container py-5">
            <div class="row d-flex justify-content-center">
                <div class="col-md-10 col-xl-8 text-center">
                    <h1 class="fw-bold mb-4">Reseñas</h1>
                    <h4 class="mb-4 pb-2 mb-md-5 pb-md-0"><?php echo $gameName; ?></h4>
                </div>
            </div>

            <div class="row text-center">
                <?php
                if (mysqli_num_rows($resultReviews) === 0) {
                    // No hay reseñas para este juego
                    echo '
                    <div class="col-12">
                      <div class="alert alert-danger" role="alert">
                        No hay reseñas para este juego...
                      </div>
                    </div>                    
                    ';
                } else {
                    // Hay reseñas para este juego
                    while ($rowReview = mysqli_fetch_assoc($resultReviews)) {
                        $userID = $rowReview['userID'];
                        $rating = $rowReview['rating'];
                        $comment = $rowReview['comment'];

                        // Obtener el nombre de usuario asociado a la reseña
                        $sqlUser = "SELECT username FROM users WHERE userID=$userID";
                        $resultUser = mysqli_query($con, $sqlUser);
                        $rowUser = mysqli_fetch_assoc($resultUser);
                        $username = $rowUser['username'];
                ?>
                        <div class="col-md-4 mb-4 mb-md-0">
                            <div class="card">
                                <div class="card-body py-4 mt-2">
                                    <div class="d-flex justify-content-center mb-4">
                                        <img src="../img/profile.png" class="rounded-circle shadow-1-strong" />
                                    </div>
                                    <h5 class="font-weight-bold"><?php echo $username; ?></h5>
                                    <h6 class="font-weight-bold my-3"><?php echo $rating; ?>/5</h6>
                                    <p class="mb-2">
                                        <i class="fas fa-quote-left pe-2"></i><?php echo $comment; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </section>
</body>

</html>