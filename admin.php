<?php

    // —— If the session does not exist, create it
    if ( !isset ( $_SESSION ) )
        session_start();

    // —— If any login information is missing, return to the form
    if ( !isset( $_SESSION["_userID"] ) || !isset( $_SESSION["Login"] ) )
        return include_once "./login.php";

?>


<!DOCTYPE html>

    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    </head>

    <body>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">-</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="./generationTest.php">Generer un test</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./ajoutQuestions.php">Ajouter des questions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="./gestionAdministrateur.php">Administrateur</a>
                        </li>
                    </ul>

                </div>

                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <?= $_SESSION["Login"] ?>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li>
                            <form method="post">
                                <button type="submit" class="dropdown-item" name="logout">Deconnexion</button>
                            </form>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>

    </body>


    <?php

        if ( isset( $_POST["logout"] ) ) {

            // —— Remove all session variables
            session_unset();

            // —— Destroy the session
            session_destroy();

            // —— Refresh page
            header("Refresh:0");

        }

    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

</html>