<?php

    ini_set( "display_errors", 1);
    ini_set( "display_startup_errors", 1);
    error_reporting( E_ALL );

    // —— Loads all the parameters of my post method.
    $content = trim(file_get_contents("php://input"));

    // —— Transforms the character string into a JSON object
    $data = json_decode($content, true);

    require "../DB.php";

    if ( !isset( $DB ) )
        echo "DATABASE ERROR ——";

    // —— A entity ID and Methode must be specified
    if ( !isset( $data[ "UserID" ] ) )
        echo "You must indicate the identifier of the target";


    if ( $data["endTest"] ) {

        $stop = $DB->prepare( "UPDATE `Candidats` SET `TempsRestant` = 0, `TempsAdRestant` = 0 WHERE _ID = ?" );
        $stop->execute( array($data["UserID"]) );

    } else {

        $test  = $DB->prepare( "SELECT `Durée`, `DuréeAdditionnel` FROM Tests WHERE `_ID` = ?" );
        $test->execute( array($data["test"]) );
        $test = $test->fetch();


        $sth    = $DB->prepare( "SELECT TempsRestant, TempsADRestant FROM `Candidats` WHERE _ID = ".$data[ 'UserID' ] );

        $sth->execute();
        $sth = $sth->fetch();

        $currentTime = $sth[0];
        $adTime = $sth[1];

        if ( $sth ) {

            if ( $currentTime > 0 ) {

                $sth = $DB->prepare( "UPDATE `Candidats` SET `TempsRestant` = ? WHERE _ID = ".$data[ 'UserID' ] );
                $sth->execute( array( $currentTime - 1 ) );

            } else {

                $sth = $DB->prepare( "UPDATE `Candidats` SET `TempsAdRestant` = ? WHERE _ID = ".$data[ 'UserID' ] );
                $sth->execute( array( $adTime - 1 ) );

            }

        }

    }


?>