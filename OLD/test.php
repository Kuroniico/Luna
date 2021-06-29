




<!DOCTYPE html>
	<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Coriolis - Guide d'entretien Collectif</title>

		<link rel="stylesheet" href="styles/style.css" />

	</head>

	<body>

		<h1>Guide d'entretien Collectif</h1>

        <div class="contactForm">

            <form class="center" method="post">

                <div>

                    <p>
                        <label for="name">Nom</label>
                        <input type="text" name="name" id="name" required>
                    </p>

                    <p>
                        <label for="firstName">Prénom</label>
                        <input type="text" name="firstName" id="firstName" required>
                    </p>

                    <p>
                        <label for="birthDate">Date de naissance</label>
                        <input type="date" name="birthDate" id="birthDate" required>
                    </p>

                    <p>
                        <label for="phone">Numéro de Teléphone</label>
                        <input type="number" name="phone" id="phone">

                    </p>

                    <p>
                        <label for="mail">Adresse mail</label>
                        <input type="email" name="mail" id="mail">
                    </p>

                    <p>
                        <label for="currentDate">Date du jour</label>
                        <input type="date" name="currentDate" id="currentDate" disabled>
                    </p>

                    <p>
                        <label for="PoleEmploiID">Identifiant Pôle Emploi</label>
                        <input type="text" name="PoleEmploiID" id="PoleEmploiID">
                    </p>

                    <p>
                        <label for="StartDisp">Date de début de disponibilité</label>
                        <input type="date" name="StartDisp" id="StartDisp">
                    </p>

                    <p>
                        <label for="EndDisp">Date de fin de disponibilité</label>
                        <input type="date" name="EndDisp" id="EndDisp">
                    </p>

                    <span>Êtes-vous d'accord pour que nous réalisions un contrôle de référence ? (séléctionnez la réponse)</span>
                    <div class="flex">
                        <label for="controlYes">Oui</label>
                        <input type="radio" id="controlYes" name="control" value="Oui">

                        <label for="controlNo">Non</label>
                        <input type="radio" id="controlNo" name="control" value="Non">
                    </div>

                    <input type="submit" name="start" value="Debuter le test >>">

                </div>

            </form>

        </div>

	</body>

    <script>

document.getElementById("currentDate").value = new Date().toLocaleDateString().split("/").reverse().join("-");

</script>

<?php

if ( isset($_POST["start"] ) ) {

    include_once "php/Common.php";
    $db = new Mysql();

    echo "preGeneration";

    $db->generateTest( $_POST );

    echo "postGeneration";

}




?>

<script src="scripts/script.js"></script>



</html>