<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

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

            require "./DB.php";

            if ( !isset( $DB ) )
                echo "DATABASE ERROR ——";

            $sth = $DB->prepare( "SELECT * FROM Categories" );

            $sth->execute();
            $sth = $sth->fetchAll();

            if ( !$sth )
                echo "no cat";

            $test = $DB->prepare( "INSERT INTO `Tests`( `NSalle`, `Localisation`, `Createur`) VALUES ( 1, 1, 1 )" );
            $test->execute();
            $test_id = $DB->lastInsertId();

            foreach ( $sth as $cIndex => $categorie ) {

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

        ?>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Navbar</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="./generationTest.php">Generer test</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./ajoutQuestions.php">Gestion question</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./gestionAdministrateur.php">Gestion administrateur</a>
                    </li>
                </ul>
            </div>
        </nav>


        <?php




            //
        // SELECT * FROM Tests INNER JOIN QuestionsTests ON QuestionsTests._IDTest = Tests._ID INNER JOIN Questions ON Questions._ID = QuestionsTests._IDQuestion WHERE Tests._ID = 55;

        ?>

        <div class="container">

            <div class="alert alert-primary mt-5 mb-5">
                Votre test a été généré, son numéro est le <b><?= $test_id ?>.</b>
            </div>

            <ul class="nav nav-tabs" id="myTab" role="tablist">

                <?php foreach ( $sth as $cIndex => $categorie ) { ?>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="<?= $cIndex; ?>" data-bs-toggle="tab" data-bs-target="#T<?= $cIndex; ?>" type="button" role="tab"><?= $categorie["Nom"]; ?></button>
                    </li>

                <?php } ?>

            </ul>

            <div class="tab-content">

                <?php foreach ( $sth as $cIndex => $categorie ) { ?>
                    <div class="tab-pane fade show pb-3" id="T<?= $cIndex; ?>" role="tabpanel" aria-labelledby="#T<?= $cIndex; ?>-tab">

                    <?php

                        $Cques = $DB->prepare( "SELECT * FROM Tests INNER JOIN QuestionsTests ON QuestionsTests._IDTest = Tests._ID INNER JOIN Questions ON Questions._ID = QuestionsTests._IDQuestion WHERE Tests._ID = ? AND Questions.Categorie = ?" );
                        $Cques->execute( array( $test_id, $categorie["Nom"] ) );

                        foreach ( $Cques as $qIndex => $question ) {

                    ?>

                        <div class="alert alert-secondary" role="alert">

                            <?php
                                if ( $question["Obligatoire"] )
                                    echo '<div class="float-end" style="color: #dc3545">*</div>';
                            ?>

                            <?= $question["Intitule"] ?>
                        </div>

                    <?php } ?>

                    </div>

                <?php } ?>

            </div>

            <span style="color: #dc3545"> * Questions obligatoires </span>

        </div>


    </body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

    <script>

    if ( document.querySelectorAll('#myTab li').length ) {

        var triggerFirstTabEl = document.querySelector('#myTab li:first-child a')

        console.log( triggerFirstTabEl );aw
        bootstrap.Tab.getInstance(triggerFirstTabEl).show() // Select first tab

    }

    </script>
</html>