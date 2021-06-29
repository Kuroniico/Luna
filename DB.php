<?php

    // —— Recursively search file hack ;3
    $level = "";

    while ( file_exists("..") && !file_exists( $level . "config.php" ) )
        $level = $level . "../";

    // —— Load configuration file
    $config = include( $level . "config.php" );

    try {

        $DB = new PDO( "mysql:host=$config[0];dbname=$config[1]", "$config[2]", "$config[3]" );

    } catch (PDOException $e) {
        echo("Error ! — " );
    }

?>