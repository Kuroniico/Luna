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


    $param  = $DB->query( "SELECT * FROM `Parametres`" );
    $sth    = $DB->prepare( "SELECT TempsRestant, TempsADRestant FROM `Candidats` WHERE _ID = ".$data[ 'UserID' ] );

    $sth->execute();
    $sth = $sth->fetch();

    $currentTime = $sth[0];
    $adTime = $sth[0];

    if ( $sth ) {

        if ( $currentTime < $param["DureeTest"] ) {

            $sth = $DB->prepare( "UPDATE `Candidats` SET `TempsRestant` = ? WHERE _ID = ".$data[ 'UserID' ] );
            $sth->execute( array( $currentTime - 1 ) );


        } else {

            $sth = $DB->prepare( "UPDATE `Candidats` SET `TempsADRestant` = ? WHERE _ID = ".$data[ 'UserID' ] );
            $sth->execute( array( $adTime - 1 ) );

        }

    }

?>