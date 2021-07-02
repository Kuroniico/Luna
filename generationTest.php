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

    // —— Load parametres
    $parametres = $DB->query( "SELECT * FROM Parametres Limit 1" );
    $parametres = $parametres->fetch( );

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    </head>
    <body>

    <?php

        if ( !isset( $DB ) )
            echo "DATABASE ERROR ——";

        $categories = $DB->query( "SELECT * FROM Categories" );
        $categories = $categories->fetchAll();

        if ( !$categories )
            echo "no cat";

    ?>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Acces formateur</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="./generationTest.php">Generer un test</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./ajoutQuestions.php">Gestion des questions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./gestionAdministrateur.php">Gestion des administrateurs</a>
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

        <h2 class="mt-5">Séléctionez les catégories</h2>
        <p class="lead mb-4">Seules les catégories sélectionnées seront utilisées pour le test.</p>
        <form method="post" id="generate">

            <dl class="row">

                <?php foreach ( $categories as $categorie ) {

                    $count = $DB->prepare( "SELECT COUNT( * ) FROM `Questions` WHERE `Categorie` = ?" );
                    $count->execute( array( $categorie["Nom"] ) );
                    $count = $count->fetch();

                    ?>

                    <dd class="col-sm-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="<?= $categorie["Nom"] ?>"
                                <?= $count[0] < $categorie["QuantiteMin"] ? "disabled" : "checked" ?>
                            >
                            <label class="form-check-label" for="<?= $categorie["Nom"] ?>"><?= $categorie["Nom"] ?></label>
                        </div>
                    </dd>
                    <dd class="col-sm-2"><?= $categorie["QuantiteMin"] ?> Question minimums </dd>
                    <dd class="col-sm-2"><?= $count[0] ?> Questions totales </dd>
                    <dd class="col-sm-5"></dd>

                <?php } ?>

            </dl>

            <h2 class="mt-5">Durée du test</h2>
            <p class="lead mb-4">Indiquez la durée du test, et le temps additionnel.</p>

            <div class="row g-2">
                <div class="col-md">

                    <div class="form-floating">
                        <input type="number" class="form-control" name="Durée" min="1" max="120" id="Durée" value="<?= $parametres["DureeTest"] ?>">
                        <label for="Durée">Durée normale</label>
                    </div>
                </div>

                <div class="col-md">

                    <div class="form-floating">
                        <input type="number" class="form-control" name="DuréeAdditionnel" min="0" max="120" id="DuréeAdditionnel" value="<?= $parametres["TempsAd"] ?>">
                        <label for="DuréeAdditionnel">Durée additionnel</label>
                    </div>
                </div>
            </div>

            <button type="submit" id="generateTest" name="generateTest" class="btn btn-primary mt-5">Générer</button>

        </form>

        <?php

            if ( isset( $_POST["logout"] ) ) {

                // —— Remove all session variables
                session_unset();

                // —— Destroy the session
                session_destroy();

                // —— Refresh page
                echo "<meta http-equiv='refresh' content='0'>";

            }

            if ( isset( $_POST["generateTest"] ) ) {

                $count = 0;
                foreach ( $_POST as $index => $selected) {

                    if ( $selected == "on" )
                        $count++;

                }

                if ( $count == 0 ) {
                    echo "<script>alert('Vous devez au minimum cocher une catégorie pour générer un test')</script>";
                    return;
                }


                $test = $DB->prepare( "INSERT INTO `Tests`( `NSalle`, `Localisation`, `Createur`, `Durée`, `DuréeAdditionnel`) VALUES ( 1, 1, 1, ?, ? )" );
                $test->execute( array(
                    $_POST["Durée"] * 60,
                    $_POST["DuréeAdditionnel"] * 60,
                ));
                $test_id = $DB->lastInsertId();


                foreach ( $_POST as $index => $selected) {

                    if ( $selected == "on" ) {

                        $categorie = array_search($index, array_column( $categories, "Nom"));
                        $categorie = $categories[$categorie];

                        $Qsth = $DB->prepare( "SELECT * FROM Questions WHERE Categorie = :categorie ORDER BY Obligatoire DESC, RAND() LIMIT :limit" );

                        $Qsth->bindValue( ":limit"      , $categorie["QuantiteMin"], PDO::PARAM_INT );
                        $Qsth->bindValue( ":categorie"  , $categorie["Nom"]        , PDO::PARAM_STR );

                        $Qsth->execute( );

                        $questions = $Qsth->fetchAll();


                        foreach ( $questions as $qIndex => $question ) {

                            $test = $DB->prepare( "INSERT INTO `QuestionsTests`( `_IDQuestion`, `_IDTest` ) VALUES ( ?, ? )" );
                            $test->execute( array(
                                $question["_ID"],
                                $test_id,
                            ));

                        }

                    }

                }

                ?>

                    <div class="alert alert-primary mt-5">
                        Votre test a été généré, son N° est le <u><b><?= $test_id ?></b></u>.
                    </div>

                <?php

            }


        ?>

    </div>


    </body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

</html>