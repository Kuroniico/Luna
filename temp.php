<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <link rel="stylesheet" href="./Styles/style.css">

    </head>
    <body>

    <?php

        require "./DB.php";

        if ( !isset( $DB ) )
            echo "DATABASE ERROR ——";

        $sth = $DB->prepare( "SELECT * FROM Categories" );

        $sth->execute();

        if ( !$sth )
            echo "no cat";

        $categories = $sth->fetchall();


    ?>

<div class="container">

    <ul class="nav nav-tabs" id="myTab" role="tablist">

    <?php
        foreach ( $categories as $key => $value  ) {
    ?>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="<?=  $key; ?>" data-bs-toggle="tab" data-bs-target="#T<?= $key; ?>" type="button" role="tab" aria-controls="home" aria-selected="true"><?= $value["Nom"]; ?></button>
        </li>
    <?php
        }
    ?>

    </ul>

    <div class="tab-content" id="myTabContent">

    <?php
        foreach ( $categories as $key => $categorie  ) {
    ?>
        <div class="tab-pane fade" id="T<?=  $key; ?>" role="tabpanel" aria-labelledby="<?=  $key; ?>-tab">

        <?php


            $Qsth = $DB->prepare( "SELECT * FROM Questions WHERE Categorie = :categorie ORDER BY Obligatoire DESC, RAND() LIMIT :limit" );

            $Qsth->bindValue( ":limit"      , $categorie["QuantiteMin"], PDO::PARAM_INT );
            $Qsth->bindValue( ":categorie"  , $categorie["Nom"]        , PDO::PARAM_STR );

            $Qsth->execute( );

            $questions = $Qsth->fetchAll();

            foreach ( $questions as $qIndex => $question ) {

                ?>

            <div class="alert alert-secondary" role="alert">
                    <?= $question["Intitule"]; ?>

          <?php

                $Rsth = $DB->prepare( "SELECT * FROM `Réponse` WHERE _IDQuestion = ?" );

                $Rsth->execute( array(
                    $question["_ID"]
                ) );

                $responses = $Rsth->fetchAll();

                // switch (  $question["ReponseType"] ) {

                //     case 1:
                //         echo "<input type='text' class='form-control' id='TODO'>";
                //         break;

                //     case 2: {

                //         foreach ( $responses as $rIndex => $response ) {

                //     ?>

                //         <div class="form-check">
                //             <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                //             <label class="form-check-label" for="flexCheckDefault">
                //                 <?= $response["Reponse"] ?>
                //             </label>
                //         </div>


                //     <?php

                //         }

                //     } break;

                //     case 3: {

                //         foreach ( $responses as $rIndex => $response ) {

                //         ?>
                //         <div class="form-check">
                //             <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                //             <label class="form-check-label" for="flexCheckDefault">
                //                 <?= $response["Reponse"] ?>
                //                 <input type='text' class='form-control' id='TODO'>
                //             </label>
                //         </div>
                //     <?php }} break;
                // }
        ?>

        </div>

        <?php
            }
        ?>

        </div>
    <?php
        }
    ?>

    </div>

</div>



    </body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>


</html>