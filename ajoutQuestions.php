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

    include_once "./DB.php";

    $Categories = $DB->query( "SELECT * FROM Categories" );
    $Categories = $Categories->fetchAll();


?>


<!DOCTYPE html>

    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <link rel="stylesheet" href="./Styles/style.css">

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
                            <a class="nav-link active" aria-current="page" href="./generationTest.php">Generer un test</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./ajoutQuestions.php">Ajouter des questions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./gestionAdministrateur.php">Administrateur</a>
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

        <div class="container">

            <div class="card mt-5">
                <div class="card-header d-grid gap-2 d-md-flex justify-content-md-end">
                    <ul class="nav nav-pills gap-2" id="pills-tab" role="tablist">
                        <?php
                        $index = 0;
                        foreach ( $Categories as $CatIndex => $Categorie ) { ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?= $index === 0 ? "active" : "" ?>" data-bs-toggle="pill" data-bs-target="#tab-<?= $index++ ?>" type="button" role="tab" aria-selected="true"><?= $Categorie["Nom"] ?></button>
                            </li>
                        <?php } ?>


                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                +
                            </button>
                        </div>
                    </ul>
                </div>

                <div class="card-body">

                    <div class="tab-content" id="pills-tabContent">

                    <?php

                    $index = 0;
                    foreach ( $Categories as $CIndex => $Categorie ) { ?>

                        <div class="tab-pane fade" id="tab-<?= $index++ ?>" role="tabpanel" >

                        <form action="" method="post">

                            <div class="row g-2">
                                <div class="col-md d-none">
                                    <div class="form-floating">
                                        <input type="tex" class="form-control" name="catName" placeholder="..." value="<?= $Categorie["Nom"] ?>">
                                        <label for="catName">Nom</label>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" name="nbrQuestionObligatoire" placeholder="..." value="<?= $Categorie["QuantiteMin"] ?>">
                                        <label for="nbrQuestionObligatoire">Nombre de question</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-floating mt-4">
                                <textarea class="form-control" placeholder="..." name="introduction" style="height: 100px"><?= $Categorie["Introduction"] ?></textarea>
                                <label for="introduction">Introduction</label>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                <button type="submit" class="btn btn-primary" name="updCategorie">Modifier</button>
                                <button type="submit" class="btn btn-danger" name="remCategorie">Supprimer</button>
                            </div>

                        </form>

                        <h4 class="mt-4 mb-4">Questions</h4>

                        <div class="alert alert-primary text-center">
                            <a href="#" class="alert-link" data-bs-toggle="modal" data-bs-target="#addQuestion">Ajouter une questions</a>.
                        </div>

                            <?php

                                $Questions = $DB->prepare( "SELECT * FROM Questions WHERE Categorie = ?" );
                                $Questions->execute( array( $Categorie["Nom"] ) );

                                foreach ( $Questions as $QIndex => $Question ) {

                                    $reponses = $DB->prepare( "SELECT * FROM `Réponse` WHERE _IDQuestion = ?" );
                                    $reponses->execute( array( $Question["_ID"] ) );

                            ?>

                                <div class="card mb-2 blueBorder">
                                    <div class="card-body">

                                        <!-- <form method="post" action="upload.php" enctype="multipart/form-data">
                                            Select image to upload:
                                            <input type="file" name="fileToUpload" id="fileToUpload">
                                            <input type="submit" name="ImageSub">
                                        </form> -->

                                        <form id="<?= $Question["_ID"] ?>">

                                            <div class="form-floating mt-4">
                                                <textarea class="form-control" placeholder="" name="Intitulé" style="height: 100px"><?= $Question["Intitule"] ?></textarea>
                                                <label for="introduction">Intitulé</label>
                                            </div>

                                            <div class="form-floating mt-2">
                                                <select class="form-select typedeRep" id="select-<?= $Question["_ID"] ?>">
                                                    <option value="1">Réponse libre</option>
                                                    <option value="2">Texte à cocher</option>
                                                    <option value="3">Texte à cocher & justification</option>
                                                </select>
                                                <label for="typedeRep">Type de réponse</label>
                                            </div>

                                            <div class="possibleRes mt-3 d-none">

                                                <h5>Réponses possibles</h5>

                                                <div class="response">

                                                    <?php foreach ( $reponses as $rIndex => $reponse) { ?>

                                                        <div id="<?= $reponse["_ID"] ?>">
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text"> <?= $rIndex + 1 ?> </span>
                                                                <input type="text" class="form-control" onChange="updateResponse( <?= $reponse["_ID"] ?>, this.value )" placeholder="Réponse possible ..." value="<?= $reponse["Reponse"] ?>">
                                                                <button class="btn btn-danger removeResponse" type="button" onClick="removeResponse( event, <?= $reponse["_ID"] ?> )">
                                                                    <i class="bi bi-dash"></i>
                                                                </button>
                                                            </div>
                                                        </div>

                                                    <?php } ?>

                                                </div>

                                                <div class="d-grid gap-2 row">
                                                    <button type="button" class="btn btn-outline-primary col" onClick="addResponse( event, <?= $Question["_ID"] ?>)">+</button>
                                                </div>
                                            </div>

                                            <div class="mb-3 form-check mt-2">
                                                <input type="checkbox" class="form-check-input Obligatoire" <?= $Question["Obligatoire"] === "1" ? "checked" : "de"  ?>>
                                                <label class="form-check-label" for="Annuler">Question Obligatoire</label>
                                            </div>

                                        </form>

                                    </div>
                                </div>

                            <?php } ?>

                        </div>


                    <?php } ?>

                    </div>

                </div>
            </div>

        </div>

        <!-- Add Category -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">

                <form class="modal-content" method="post">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ajouter une catégorie</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="nom" placeholder="...">
                                <label for="nom">Nom</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="..." name="introduction" style="height: 100px"></textarea>
                                <label for="introduction">Introduction</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating">
                                <input type="number" class="form-control" name="nbrQuestionObligatoire" placeholder="...">
                                <label for="nbrQuestionObligatoire">Nombre de question obligatoire</label>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary" name="addCategorie">Ajouter</button>
                    </div>

                </form>

            </div>
        </div>

        <div class="modal fade" id="addQuestion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addQuestion" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post">
                        <div class="modal-header">
                            <h5 class="modal-title">Ajouter une question</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <div class="form-floating">
                                <textarea class="form-control" placeholder="" name="Intitulé" style="height: 100px"></textarea>
                                <label for="introduction">Intitulé</label>
                            </div>

                            <div class="form-floating mt-2">
                                <select class="form-select" name="responseType">
                                    <option value="1">Réponse libre</option>
                                    <option value="2">Texte à cocher</option>
                                    <option value="3">Texte à cocher & justification</option>
                                </select>
                                <label for="typedeRep">Type de réponse</label>
                            </div>

                            <div class="mb-3 form-check mt-2">
                                <input type="checkbox" class="form-check-input" name="Obligatoire">
                                <label class="form-check-label" for="Annuler">Question Obligatoire</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" name="addQuestionForm" class="btn btn-primary">Ajouter</button>
                        </div>

                    <form>
                </div>
            </div>
        </div>

    </body>


    <?php

        if ( isset( $_POST["addQuestionForm"] ) ) {
            print_r($_POST );
        }

        if ( isset( $_POST["logout"] ) ) {

            // —— Remove all session variables
            session_unset();

            // —— Destroy the session
            session_destroy();

            // —— Refresh page
            echo "<meta http-equiv='refresh' content='0'>";

        }

        if ( isset( $_POST["addCategorie"] ) ) {

            $addCategory = $DB->prepare( "INSERT INTO `Categories`(`Nom`, `Introduction`, `QuantiteMin`) VALUES ( ?, ?, ? )" );
            $addCategory->execute( array(
                $_POST["nom"],
                $_POST["introduction"],
                $_POST["nbrQuestionObligatoire"],
            ) );

            // —— Refresh page
            echo "<meta http-equiv='refresh' content='0'>";

        }

        if ( isset( $_POST["remCategorie"] ) ) {

            $remQuestion = $DB->prepare( "DELETE FROM `Questions` WHERE `Categorie` = ?" );
            $remQuestion->execute( array( $_POST["catName"] ) );

            $remCategorie = $DB->prepare( "DELETE FROM `Categories` WHERE `Nom` = ?" );
            $remCategorie->execute( array( $_POST["catName"] ) );

            echo "<meta http-equiv='refresh' content='0'>";

        }

        if ( isset( $_POST["updCategorie"] ) ) {

            $updCategorie = $DB->prepare( "UPDATE `Categories` SET `Introduction`= ? ,`QuantiteMin`= ? WHERE Nom = ?" );
            $updCategorie->execute( array(
                $_POST["introduction"],
                $_POST["nbrQuestionObligatoire"],
                $_POST["catName"]
            ) );

            echo "<meta http-equiv='refresh' content='0'>";

        }

    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

    <script src="./test.js"> </script>
</html>