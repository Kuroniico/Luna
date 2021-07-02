<?php

    ini_set( "display_errors", 1);
    ini_set( "display_startup_errors", 1);
    error_reporting( E_ALL );
    // —— If the session does not exist, create it
    if ( !isset ( $_SESSION ) )
        session_start();

    // —— If any login information is missing, return to the form
    if ( !isset( $_SESSION["_userID"] ) || !isset( $_SESSION["Login"] ) )
        return include_once "./login.php";

    require_once "./DB.php";


    $loadParameter = $DB->query( "SELECT * FROM Parametres LIMIT 1" );
    $loadParameter = $loadParameter->fetch();

    if ( isset( $_POST["save"] ) ) {

        $newParam = $DB->prepare( "UPDATE `Parametres` SET `DureeTest`= ?,`TempsAd`= ?,`ServerSMTP`= ?,`SecureSMTP`= ?,`PortSMTP`=?,`UserSMTP`= ?,`PasswordSMTP`=?,`FromSMTP`=?,`ToSMTP`=? WHERE 1" );
        $newParam->execute( array(
            $_POST["Durée"],
            $_POST["DuréeAdditionnel"],
            $_POST["ServerSMTP"],
            $_POST["SecureSMTP"],
            $_POST["PortSMTP"],
            $_POST["UserSMTP"],
            $_POST["PasswordSMTP"],
            $_POST["FromSMTP"],
            $_POST["ToSMTP"]
        ) );

        echo "<meta http-equiv='refresh' content='0'>";

    }


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
            <div class="container">
                <a class="navbar-brand" href="#">Acces formateur</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="./generationTest.php">Generer un test</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./ajoutQuestions.php">Gestion des questions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./gestionAdministrateur.php">Gestion des administrateurs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="./parametres.php">Parametres</a>
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
        </nav>

        <div class="container">

            <form name="updateParam" method="post">

                <h2 class="mt-5">Parametres par défault</h2>
                <p class="lead mb-4">Indiquez la durée du test, et le temps additionnel par default</p>

                <div class="row g-2">
                    <div class="col-md">

                        <div class="form-floating">
                            <input type="number" class="form-control" name="Durée" id="Durée" value="<?= $loadParameter["DureeTest"] ?>" min="1" max="120">
                            <label for="Durée">Durée normale</label>
                        </div>
                    </div>

                    <div class="col-md">

                        <div class="form-floating">
                            <input type="number" class="form-control" name="DuréeAdditionnel" id="DuréeAdditionnel" value="<?= $loadParameter["TempsAd"] ?>" min="0" max="120">
                            <label for="DuréeAdditionnel">Durée additionnel</label>
                        </div>

                    </div>
                </div>

                <h2 class="mt-5">Paramètres serveur Mail</h2>
                <p class="lead mb-4">Informations sur le serveur d'envois, et l'adresse de réception du mail</p>

                <h6>Serveur de courrier sortant (SMTP) :</h6>

                <div class="row g-2">
                    <div class="col-8">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="ServerSMTP" name="ServerSMTP" value="<?= $loadParameter["ServerSMTP"] ?>" required>
                            <label for="ServerSMTP">Serveur SMTP</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="SecureSMTP" name="SecureSMTP" value="<?= $loadParameter["SecureSMTP"] ?>" required>
                            <label for="SecureSMTP">Sécurité</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating">
                            <input type="number" class="form-control" id="PortSMTP" name="PortSMTP" value="<?= $loadParameter["PortSMTP"] ?>" required>
                            <label for="PortSMTP">Port</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="UserSMTP" name="UserSMTP" value="<?= $loadParameter["UserSMTP"] ?>" required>
                            <label for="UserSMTP">Nom d'utilisateur</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-floating">
                            <input type="password" class="form-control" id="PasswordSMTP" name="PasswordSMTP" value="<?= $loadParameter["PasswordSMTP"] ?>" required>
                            <label for="PasswordSMTP">Mot de passe</label>
                        </div>
                    </div>

                    <div class="mt-4"></div>

                    <div class="col-6">
                        <div class="form-floating">
                            <input type="email" class="form-control" id="FromSMTP" name="FromSMTP" value="<?= $loadParameter["FromSMTP"] ?>" required>
                            <label for="FromSMTP">Adresse émettrice</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-floating">
                            <input type="email" class="form-control" id="ToSMTP" name="ToSMTP" value="<?= $loadParameter["ToSMTP"] ?>" required>
                            <label for="ToSMTP">Adresse réceptrice</label>
                        </div>
                    </div>

                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button class="btn btn-primary mt-2" name="save" type="submit">Sauvegarder</button>
                </div>

            </form>

        </div>

        </body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

</html>