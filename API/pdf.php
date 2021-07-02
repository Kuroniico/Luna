<?php


    include_once "../DB.php";

    $candidat = $DB->prepare( "SELECT * FROM Candidats WHERE _Token = ?" );
    $candidat->execute( array( $_GET["uid"] ) );
    $candidat = $candidat->fetch( );

    $test = $DB->prepare( "
        SELECT * FROM Tests

            INNER JOIN QuestionsTests   ON QuestionsTests._IDTest   = Tests._ID
            INNER JOIN Questions        ON Questions._ID            = QuestionsTests._IDQuestion
            INNER JOIN Categories       ON Questions.Categorie      = Categories.Nom

        WHERE Tests._ID = ?;

    " );
    $test->execute( array( $_GET["test"] ) );

    $tests = array();

    foreach( $test as $val ) {
        if( array_key_exists( "Categorie", $val ) ){
            $tests[$val["Categorie"]][] = $val;
        }else{
            $tests[""][] = $val;
        }
    }

?>


<style type="text/css">

    table.page_header {
        width: 100%;
        border: none;
        background-color: #DDDDFF;
        border-bottom: solid 1mm #AAAADD;
        padding: 2mm
    }

    table.page_footer {
        width: 100%;
        border: none;
        background-color: #0091d8;
        padding: 2mm;
        color: white
    }

    div.note {
        border: solid 1mm #DDDDDD;
        background-color: #EEEEEE;
        padding: 2mm;
        border-radius: 2mm;
        width: 100%;
    }

    ul.main {
        width: 95%;
        list-style-type: square;
    }

    ul.main li {
        padding-bottom: 2mm;
    }

    .question {
        font-weight: bold;
    }

    .indent {
        margin-left: 30px;
    }

</style>
<page backtop="14mm" backbottom="14mm" backleft="10mm" backright="10mm" style="font-size: 12pt">
    <page_footer>
        <table class="page_footer">
            <tr>
                <td style="width: 33%; text-align: left;">

                </td>
                <td style="width: 34%; text-align: center">
                    page [[page_cu]]/[[page_nb]]
                </td>
                <td style="width: 33%; text-align: right">

                </td>
            </tr>
        </table>
    </page_footer>
    <bookmark title="Présentation" level="0" ></bookmark>
        <div style="width: 100%; margin-left: 85%;">

            <h1 style="margin-left: 3px;">Avis</h1>
                <h3 style="position: relative;">
                <div style="height: 13px;width: 13px;display: -webkit-inline-box;border: 1px solid black;border-radius: 3px;position: absolute;top: 3px;left: -21px;"></div>
                Favorable
            </h3>
                <h3 style="position: relative; top: -30px ">
                <div style="height: 13px;width: 13px;display: -webkit-inline-box;border: 1px solid black;border-radius: 3px;position: absolute;top: 3px;left: -21px;"></div>
                Non favorable
            </h3>

        </div>
    <br><br><br><br><br>
    <h1>Guide d'entretien Collectif</h1>
    <h3>Amiens</h3><br>
    <br><br><br>
    <div style="text-align: center; width: 100%;">
        <br>

        <br>
    </div>
    <br><br><br><br><br>
    <div class="note">

        <table class="table">
            <tbody>
                <tr>
                    <th scope="row">Nom</th>
                    <td><?= $candidat["Nom"]?></td>
                </tr>
                <tr class="tablePane">
                    <th scope="row">Prénom</th>
                    <td><?= $candidat["Prenom"]?></td>
                </tr>
                <tr class="tablePane">
                    <th>Date de naissance</th>
                    <td><?= $candidat["DateDeNaissance"]?></td>
                </tr>
                <tr>
                    <th class="tablePane">Téléphone</th>
                    <td><?= $candidat["Telephone"]?></td>
                </tr>
                <tr>
                    <th class="tablePane">Mail</th>
                    <td><?= $candidat["Mail"]?></td>
                </tr>

                <tr>
                    <th class="tablePane">Date du jour</th>
                    <td><?= $candidat["DateDuJour"]?></td>
                </tr>

                <tr>
                    <th>ID Pôle Emploi</th>
                    <td><?= $candidat["IDPEmploi"]?></td>
                </tr>
                <tr>
                    <th>Date début disponibilité</th>
                    <td><?= $candidat["DateDebutDisp"]?></td>
                </tr>
                <tr>
                    <th>Date fin disponibilité</th>
                    <td><?= $candidat["DatefinDisp"] ?></td>
                </tr>

            </tbody>
        </table>



    </div>
</page>
<page pageset="old">

    <?php

        $cCount = 1;
        $qCount = 1;
        foreach ( $tests as $cIndex => $categorie ) {
            echo "<h3>".$cCount++.". $cIndex</h3>";
            echo "<div class='indent'>";

            foreach ( $categorie as $qIndex => $question ) {

                echo "<p class='question'>".$qCount++.". ".$question["Intitule"]."</p>";

                $responses = $DB->prepare( "SELECT * FROM `ReponsesTests` WHERE `_IDQuestion` = ? AND `_IDTest` = ? AND `_IDCantidat` = ?" );
                $responses->execute( array(
                    $question["_ID"],
                    $_GET["test"],
                    $candidat["_ID"]
                ));
                $responses = $responses->fetchAll();

                if ( empty( $responses ) ) {
                    echo "<span class='indent'> - </span>";
                } else {

                    switch ( $question["ReponseType"] ) {
                        case 1:
                            echo "<span class='indent'> - ".$responses[0]["Reponse"]."d</span>";
                            break;

                        case 2: {

                            echo "<span class='indent'> - ".$responses[0]["Reponse"]."d</span>";

                        } break;



                        default:
                            # code...
                            break;
                    }

                    // if ( $question["ReponseType"] != 1 ) {

                    // } else {

                    // }



                    //     if ( $question["ReponseType"] != 1 ) {

                    //         $select = $DB->prepare( "SELECT * FROM `Réponse` WHERE `Type` = ? AND `_IDQuestion` = ?" );
                    //         $select->execute( array(
                    //             $question["_ID"],
                    //             $question["_ID"]
                    //         ) );


                    //         //echo "<span class='indent'> - ".$select[2]."</span>";



                    // } else echo "<span class='indent'> - ".$response["Reponse"]."</span>";

                }

            }

            echo "</div>";

        }

    ?>

</page>