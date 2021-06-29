<?php

    include_once( "php/Common.php" );

    $db = new Mysql();

    $test = $db->getTest( $_GET['token'] );

    $result = array();
    foreach ($test as $element) {
        $result[$element['Categorie']][] = $element;
    }


?>

<script>


    setInterval(timer(), 1000);

    function timer() {

    }
</script>

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

            <?php foreach ( $result as $categorie ) { ?>

                <button class="tablinks" data-href="<?= $categorie[0]["Categorie"] ?>"><?=$categorie[0]["Categorie"] ?></button>

            <?php } ?>

        </div>

        <?php foreach ( $result as $categorie ) { ?>

            <div id="<?= $categorie[0]["Categorie"] ?>" class="tabcontent">

                <?php foreach ( $categorie as $question ) {

                    echo $question["Intitule"];

                } ?>

            </div>

        <?php } ?>

    </body>

    <script src="./scripts/script.js"></script>
</html>
