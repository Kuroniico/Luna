<!-- <link rel="stylesheet" href="strengthify.css">
<script src="//code.jquery.com/jquery.min.js"></script>
<script src="jquery.strengthify.js"></script> -->

<?php

    // —— If the session does not exist, create it
    if ( !isset ( $_SESSION ) )
        session_start();

    // —— If any login information is missing, return to the form
    if ( !isset( $_SESSION["_userID"] ) || !isset( $_SESSION["Login"] ) || !isset( $_SESSION["Local"] ) )
        return include_once "../admin.php";

    include_once "../php/Common.php";
    $DB = new Mysql();

    $adminList = $DB->getAdmins( $_SESSION["Local"] );

    print_r($adminList);

?>


<!DOCTYPE html>

    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>

        <link rel="stylesheet" href="../styles/bootstrap.css">

    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">-</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Generer un test</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Ajouter des questions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Administrateur</a>
                        </li>
                    </ul>

                </div>
                <form class="d-flex">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <?= $_SESSION["Login"] ?>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="#">Deconnexion</a></li>
                    </ul>
                    </div>
                </form>
            </div>
        </nav>

        <div class="container">

            <?php

                foreach ( $adminList as $admin ) {
                    echo $admin["_Mail"];
                }

            ?>


        </div>


    </body>

    <script src="../scripts/bootstrap.js"></script>

</html>