
<?php

    // —— If the session does not exist, create it
    if ( !isset( $_SESSION ) )
        session_start();

    if ( !isset( $_SESSION["IDTest"] ) )
        return header( "Location: ./index.php" );

?>

<!DOCTYPE html>

    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inscription</title>
    </head>
    <body>

    </body>

</html>