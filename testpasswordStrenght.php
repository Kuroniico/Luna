


<!DOCTYPE html>
	<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Coriolis - Connexion formateur</title>


        <link rel="stylesheet" href="./Styles/passwordCheck.css">
<!-- Jtm :b  -->
	</head>

	<body>

		<!-- <h1>Guide d'entretien Collectif</h1> -->

        <div class="contactForm">

            <form class="center" method="post">

                <div>

                    <p>

                    </p>

                    <p>
                        <div class="wrap">
                            <div class="group login">
                                <input type="text" id="login" name="login">
                                <label for="login">Login</label>
                            </div>
                            <br>
                            <div class="group password">
                                <input type="password" id="pas">
                                <label for="pas">Mot de passe</label>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80">
                                    <path d="M39.5 49.5C31.688 49.5 25 42.258 25 40c0-1.862 6.514-9.5 14.5-9.5S54 38.138 54 40c0 2.661-6.894 9.5-14.5 9.5zm-12.491-9.453c.319 1.366 5.78 7.453 12.491 7.453 6.804 0 12.234-6.101 12.493-7.461-.436-1.315-5.808-7.539-12.493-7.539-6.553 0-12 6.208-12.491 7.547z" />
                                    <path d="M39.5 45.5c-3.033 0-5.5-2.467-5.5-5.5s2.467-5.5 5.5-5.5c3.032 0 5.5 2.467 5.5 5.5s-2.468 5.5-5.5 5.5zm0-9c-1.93 0-3.5 1.57-3.5 3.5s1.57 3.5 3.5 3.5S43 41.93 43 40s-1.57-3.5-3.5-3.5z" /></svg>
                            </div>
                            <div class="tips">
                                <p>Au moins une <span class="upper">lettre majuscule,</span> <span class="number">un nombre</span> et <span class="special">un caractère spécial</span> </p>
                                <div class="count">
                                    <span class="from">0</span>/<span>6</span>
                                </div>
                            </div>
                        </div>
                    </p>

                    <input type="submit" name="start" value="Debuter le test >>">

                </div>

            </form>

        </div>

	</body>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="./Scripts/passwordcheck.js"></script>


</html>