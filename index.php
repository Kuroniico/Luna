
<?php include_once "DB.php"; ?>

<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>

        <link rel="stylesheet" href="./Styles/Particleground.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <link rel="stylesheet" href="./Styles/style.css">

    </head>
    <body>

        <div id="particles-background" class="vertical-centered-box"></div>
        <div id="particles-foreground" class="vertical-centered-box"></div>

        <div class="vertical-centered-box">

            <div class="content">

                <img src="./Assets/logo.png" width="300">

                <div class="card">

                    <?php

                        // —— If user send form
                        if( isset($_REQUEST["goTest"] ) ) {

                            $lastID = $DB->query( "SELECT `_ID` FROM Candidats ORDER BY `_ID` DESC LIMIT 1;" );

                            $lastID = $lastID->fetch();

                            $testDuration = $DB->prepare( "SELECT `Durée`, `DuréeAdditionnel` FROM `Tests` WHERE `_ID` = ?" );
                            $testDuration->execute(array(
                                $_POST["IDTest"],
                            ));

                            $testDuration = $testDuration->fetch();

                            $insert = $DB->prepare( "INSERT INTO `Candidats`( `_Token`, `Nom`, `Prenom`, `DateDeNaissance`, `Telephone`, `Mail`, `IDPEmploi`, `DateDebutDisp`, `DatefinDisp`, `TempsRestant`,  `TempsAdRestant` )
                                                    VALUES                 ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )" );

                            $token = $_POST['Nom'][0].$_POST['Prenom'][0] .$lastID[0];
                            $insert->execute( array(
                                $token,
                                $_POST["Nom"],
                                $_POST["Prenom"],
                                $_POST["DateDeNaissance"],
                                $_POST["Telephone"],
                                $_POST["Mail"],
                                $_POST["IDPoleE"],
                                $_POST["StartDisp"],
                                $_POST["EndDisp"],
                                $testDuration["Durée"],
                                $testDuration["DuréeAdditionnel"]
                            ));

                            header( "Location: test.php?uid=".$token."&test=".$_POST["IDTest"] );

                        }

                    ?>

                    <form method="post" class="card-body">

                        <div id="validTest">

                            <div class="mb-3">
                                <label for="IDTest" class="form-label">Numero de test</label>
                                <input type="number" min="0" class="form-control" id="IDTest" name="IDTest" onkeydown="return (event.keyCode!=13);">
                            </div>
                            <button type="button" id="validForm" class="btn btn-primary w-100" disabled> Debuter le test </button>

                        </div>

                        <div class="d-none" id="userInfos">

                            <div class="row">
                                <div class="col-sm">

                                    <label for="Nom" class="form-label">Nom</label>
                                    <input type="text" class="form-control" id="Nom" name="Nom" required >

                                    <label for="Prenom" class="form-label">Prenom</label>
                                    <input type="text" class="form-control" id="Prenom" name="Prenom" required >

                                    <label for="DateDeNaissance" class="form-label">Date de naissance</label>
                                    <input type="date" class="form-control" id="DateDeNaissance" name="DateDeNaissance" required >

                                    <label for="Mail" class="form-label">Mail</label>
                                    <input type="mail" class="form-control" id="Mail" name="Mail">

                                    <label for="Telephone" class="form-label">Téléphone</label>
                                    <input type="phone" class="form-control" id="Telephone" name="Telephone">

                                    <label for="Today" class="form-label">Date du jour</label>
                                    <input type="date" class="form-control" id="Today" name="Today" disabled>

                                    <label for="IDPoleE" class="form-label">Identifiant Pôle Emploi</label>
                                    <input type="text" class="form-control" id="IDPoleE" name="IDPoleE" >

                                    <label for="StartDisp" class="form-label">Date de début disponibilité</label>
                                    <input type="date" class="form-control" id="StartDisp" name="StartDisp" >

                                    <label for="EndDisp" class="form-label">Date de fin disponibilité</label>
                                    <input type="date" class="form-control" id="EndDisp" name="EndDisp">

                                    <!-- <p>Contrôle de référence</p>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                        <label class="form-check-label" for="inlineRadio1">Oui</label>
                                    </div> -->
<!--
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                                        <label class="form-check-label" for="inlineRadio2">Non</label>
                                    </div> -->

                                    <button class="btn btn-primary w-100 mt-3" type="submit" name="goTest" > Débuter le test </button>

                                </div>

                            </div>

                        </div>

                    </form>

                </div>

                <a class="adminAcces" href="login.php"> Acces Formateur </a>

            </div>
        </div>

    </body>

    <script src="./Scripts/Particleground.js"></script>
    <script src="./Scripts/tets.js"></script>

</html>