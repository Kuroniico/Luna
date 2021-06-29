<?php

    // —— Loads all the parameters of my post method.
    $content = trim(file_get_contents("php://input"));

    // —— Transforms the character string into a JSON object
    $data = json_decode($content, true);

    require "../DB.php";

    if ( !isset( $DB ) )
        echo "DATABASE ERROR ——";

    // —— A entity ID and Methode must be specified
    if ( !isset( $data[ "ID" ] ) )
        echo "You must indicate the identifier of the target";

    $sth = $DB->prepare( "SELECT COUNT( * ) FROM Tests WHERE _ID = ".$data[ 'ID' ] );

    $sth->execute();
    $sth = $sth->fetch();

    echo $sth[0];

?>