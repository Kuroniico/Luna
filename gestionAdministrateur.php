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
                            <a class="nav-link active" href="./gestionAdministrateur.php">Gestion des administrateurs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./parametres.php">Parametres</a>
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

            <div class="card mb-5 mt-5">
                <div class="card-body">
                    <h5 class="card-title">Ajouter un nouvel administrateur</h5>

                    <form method="post">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col">
                                    <label for="addAdminMail" class="form-label">Adresse Mail </label>
                                    <input type="email" class="form-control" name="addAdminMail" required>
                                </div>
                                <div class="col-auto">
                                    <label for="addAdminRegion" class="form-label">Code région</label>
                                    <input type="text" class="form-control" name="addAdminRegion" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control" name="addAdminPass" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="addAdmin">Ajouter</button>
                    </form>

                </div>
            </div>

            <div class="accordion" id="admin">

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            admin@coriolis.fr
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            Les informations de l'administrateur global ne peuvent être modifiées.
                        </div>
                    </div>
                </div>

            <?php

                include_once "./DB.php";

                $admins = $DB->query( "SELECT * FROM Admins LIMIT 100 OFFSET 1;" );

                foreach ( $admins as $key => $admin) { ?>

                    <div class="accordion-item">

                        <h2 class="accordion-header" id="heading<?= $admin["ID"] ?>">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $admin["ID"] ?>" aria-expanded="false" aria-controls="collapse<?= $admin["ID"] ?>">
                                <?= $admin["_Mail"] ?>
                            </button>
                        </h2>

                        <div id="collapse<?= $admin["ID"] ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $admin["ID"] ?>" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <form method="post">
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col">
                                                <label for="updateMail" class="form-label">Adresse Mail </label>
                                                <input type="email" class="form-control" name="updateMail" value="<?= $admin["_Mail"] ?>" required>
                                            </div>
                                            <div class="col-auto">
                                                <label for="updateRegion" class="form-label">Code région</label>
                                                <input type="text" class="form-control" name="updateRegion" value="<?= $admin["Localisation"] ?>" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="updatePass" class="form-label">Mot de passe</label>
                                        <input type="password" class="form-control" name="updatePass" value="<?= $admin["_Password"] ?>" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="updateAdmin" value="<?= $admin["ID"] ?>">Modifier</button>
                                    <button type="submit" class="btn btn-danger" name="deleteAdmin" value="<?= $admin["ID"] ?>">Supprimer</button>
                                </form>
                            </div>
                        </div>
                    </div>

                <?php } ?>

            </div>

        </div>

    </body>


    <?php

        if ( isset( $_POST["logout"] ) ) {

            // —— Remove all session variables
            session_unset();

            // —— Destroy the session
            session_destroy();

            // —— Refresh page
            echo "<meta http-equiv='refresh' content='0'>";

        }

        if ( isset( $_POST["addAdmin"] ) ) {

            $insertAdmin = $DB->prepare( "INSERT INTO `Admins`(`_Mail`, `_Password`, `Localisation`) VALUES ( ?, ?, ? )" );
            $insertAdmin->execute( array(
                $_POST["addAdminMail"],
                $_POST["addAdminPass"],
                $_POST["addAdminRegion"],
            ));

            echo "<meta http-equiv='refresh' content='0'>";

        }

        if ( isset( $_POST["updateAdmin"] ) ) {

            if ( isset( $_POST[ "updateMail" ] ) ) {

                $update = $DB->prepare( "UPDATE `Admins` SET `_Mail` = ? WHERE `ID`= ?" );
                $update->execute( array( $_POST["updateMail"], $_POST["updateAdmin"] ) );

            }

            if ( isset( $_POST[ "updatePass" ] ) ) {

                $update = $DB->prepare( "UPDATE `Admins` SET `_Password` = ? WHERE `ID`= ?" );
                $update->execute( array( $_POST["updatePass"], $_POST["updateAdmin"] ) );

            }

            if ( isset( $_POST[ "updateRegion" ] ) ) {

                $update = $DB->prepare( "UPDATE `Admins` SET `Localisation` = ? WHERE `ID`= ?" );
                $update->execute( array( $_POST["updateRegion"], $_POST["updateAdmin"] ) );

            }

            echo "<meta http-equiv='refresh' content='0'>";

        }

        if ( isset( $_POST["deleteAdmin"] ) ) {

            $remove = $DB->prepare( "DELETE FROM `Admins` WHERE ID = ?" );
            $remove->execute( array( $_POST["deleteAdmin"] ) );

            echo "<meta http-equiv='refresh' content='0'>";

        }

    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

</html>