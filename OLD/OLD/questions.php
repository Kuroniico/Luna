<?php

    include_once( "php/Common.php" );

    $db = new Mysql();

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Document</title>
        <link rel="stylesheet" href="./styles/style.css">
    </head>
    <body>

        <div class="tab">

            <?php foreach ( $db->getCategory() as $categorie ) { ?>

                <button class="tablinks" data-href="<?= $categorie["Nom"] ?>"><?= $categorie["Nom"] ?></button>

            <?php } ?>

        </div>

        <?php foreach ( $db->getCategory() as $categorie ) { ?>

            <div id="<?= $categorie["Nom"] ?>" class="tabcontent">
                <h3><?= $categorie["Nom"] ?></h3>

                <?php foreach ( $db->generateQuestions( $categorie ) as $question ) {

                    echo $question["Intitule"];

                } ?>

            </div>

        <?php } ?>

    </body>

    <script src="./scripts/script.js"></script>
</html>











