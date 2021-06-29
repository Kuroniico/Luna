<!DOCTYPE html>
	<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Coriolis - Connexion formateur</title>


        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <link rel="stylesheet" href="./Styles/Particleground.css">

	</head>

	<body>

        <div id="particles-background" class="vertical-centered-box"></div>
        <div id="particles-foreground" class="vertical-centered-box"></div>

        <div class="vertical-centered-box">
            <div class="content">
                <div class="card">
                    <div class="card-body">
                        <form method="post" >
                            <div class="mb-3">
                                <label for="email" class="form-label">Adresse Mail</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Envoyer</button>

                            <span id="formInfo"></span>

                        </form>
                    </div>
                </div>
            </div>
        </div>

	</body>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="./Scripts/Particleground.js"></script>

    <?php

        include_once "./DB.php";

        // —— If user send form
        if ( isset( $_POST["submit"] ) ) {

            // —— If password input and username input are not empty
            if( ( !empty( $_POST["email"] ) ) && ( !empty( $_POST[ 'password' ] ) ) ) {

                // Prepare and execute user selection in database
                $stmt = $DB->prepare( "SELECT * FROM `Admins` WHERE _Mail = ?" );
                $stmt->execute( array( $_POST["email"] ) );
                $stmt = $stmt->fetch();

                // —— If no user are found, show error message
                if ( $stmt ) {

                    if ( $_POST["password"] === $stmt["_Password"] ) {

                         // —— Start new session and add user data
                        if ( !isset ( $_SESSION ) ) session_start();

                        $_SESSION['_userID']    = $stmt["ID"];
                        $_SESSION['Login']      = $_POST['email'];

                        header( "Location: ./admin.php ");


                    } else echo "<script>document.getElementById('formInfo').innerHTML = 'Wrong password' </script>";

                } else echo "<script>document.getElementById('formInfo').innerHTML = 'Wrong username or password' </script>";
            }
        }

    ?>


</html>