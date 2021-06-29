<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

?>

<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Administration</title>

        <link rel="stylesheet" href="./styles/bootstrap.css">
    </head>
    <body>

        <div class="flexCenter login">

            <div>
                <h3> Accès formateur </h3>
                <h5> Test </h5>
                <form method="post" >
                    <div class="mb-3">
                        <label for="mail" class="form-label">Adresse Mail</label>
                        <input type="email" class="form-control" name="email" >
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" name="password">
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Envoyer</button>

                    <span id="formInfo"></span>

                </form>
            </div>

    </body>

    <?php

        include_once "php/Common.php";

        $DB = new Mysql();

        // —— If user send form
        if ( isset( $_POST["submit"] ) ) {

            // —— If password input and username input are not empty
            if( ( !empty( $_POST['email'] ) ) && ( !empty( $_POST['password'] ) ) ) {

                $state = $DB->checkLogin( $_POST['email'], $_POST['password'] );

                if ( $state === 1 ) {
                    echo "<script>document.getElementById('formInfo').innerHTML = 'Wrong username or password' </script>";
                } else {

                    // —— If password is correct, start new session and add user data
                    if  ( !isset( $_SESSION ) ) session_start();

                    $_SESSION["_userID"] = $state["ID"];
                    $_SESSION["Login"]   = $state["_Mail"];
                    $_SESSION["Local"]   = $state["Localisation"];

                    header( "Refresh:0" );


                }

            }
        }

     ?>

</html>