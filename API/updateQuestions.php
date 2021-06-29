<?php


    ini_set( "display_errors", 1);
    ini_set( "display_startup_errors", 1);
    error_reporting( E_ALL );

    // —— Loads all the parameters of my post method.
    $content = trim(file_get_contents("php://input"));

    // —— Transforms the character string into a JSON object
    $data = json_decode( $content, true );

    if ( !isset( $data[ "method" ] ) )
        echo "You must indicate operation";

    require "../DB.php";

    switch ( $data[ "method" ] ) {
        case 'removeResponse': {

            $stmt = $DB->prepare( "DELETE FROM Réponse WHERE `_ID` = ?" );
            $stmt->execute( array( $data["idRep"]));

        } break;

        case 'updateResponse': {

            $stmt = $DB->prepare( "UPDATE Réponse SET Reponse = ? WHERE `_ID` = ?" );
            $stmt->execute( array( $data["response"], $data["idRep"] ) );

        } break;

        case 'addResponse': {

            $stmt = $DB->prepare( "INSERT INTO `Réponse`(`_IDQuestion`, `Type`) VALUES ( ?, ? )" );

            $stmt->execute( array(
                $data["idQuestion"],
                $data["typeResp"]
            ) );

            $lastID = $DB->query("SELECT `_ID` FROM Réponse ORDER BY `_ID` DESC LIMIT 1;");
            $lastID = $lastID->fetch();

            echo $lastID["_ID"];

        } break;

        case 'obligatoire': {

            $stmt = $DB->prepare( "UPDATE Questions SET Obligatoire = ? WHERE `_ID` = ?" );
            $stmt->execute( array( $data["state"] === true ? 1 : 0, $data["idQuestion"] ) );

        } break;


        default:
            # code...
            break;
    }




?>
