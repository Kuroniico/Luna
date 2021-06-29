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

            <form action="" class="center">
                    <div>

                        <p>
                            <label for="name">Nom</label>
                            <input type="text" name="name" id="name" require>
                        </p>

                        <p>
                            <label for="firstName">Prénom</label>
                            <input type="text" name="firstName" id="firstName" require>
                        </p>

                        <p>
                            <label for="birthDate">Date de naissance</label>
                            <input type="date" name="birthDate" id="birthDate" require>
                        </p>

                        <p>
                            <label for="mail">Adresse mail</label>
                            <input type="email" name="mail" id="mail">
                        </p>

                        <p>
                            <label for="currentDate">Date du jour</label>
                            <input type="date" name="currentDate" id="currentDate" require disabled>
                        </p>

                        <p>
                            <label for="PoleEmploiID">Identifiant Pôle Emploi</label>
                            <input type="text" name="PoleEmploiID" id="PoleEmploiID" require>
                        </p>

                        <p>
                            <label for="birthDate">Date de début de disponibilité</label>
                            <input type="date" name="birthDate" id="birthDate" require>
                        </p>

                        <p>
                            <label for="mail">Date de fin de disponibilité</label>
                            <input type="date" name="mail" id="mail" require>
                        </p>

                        <span>Êtes-vous d'accord pour que nous réalisions un contrôle de référence ? (séléctionnez la réponse)</span>
                        <div class="flex">
                            <input type="radio" id="controlYes" name="control" value="Oui">
                            <label for="controlYes">Oui</label>

                            <input type="radio" id="controlNo" name="control" value="Non">
                            <label for="controlNo">Non</label>
                        </div>



                </div>

            </form>


        </div>

	</body>

	<script src="scripts/script.js"></script>

    <script>

        document.getElementById("currentDate").value = new Date().toLocaleDateString().split("/").reverse().join("-");

    </script>

</html>