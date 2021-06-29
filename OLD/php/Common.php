<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // —— Tecursively search file hack ;3
    $level = "";

    while (file_exists("..") && !file_exists($level . "config.php"))
        $level = $level . "../";

    // —— Load configuration file
    $config = include($level . "config.php");

    class Mysql extends DbConfig {

        function __construct( ){

            $this -> connection = NULL;
            $this -> SQLQuery   = NULL;
            $this -> dataSet    = NULL;

            $credentials = new DBConfig();
            $credentials->Connection();

            $this -> DBName     = $credentials -> DBName;
            $this -> DBHost     = $credentials -> DBHost;
            $this -> UserLogin  = $credentials -> UserLogin;
            $this -> UserPass   = $credentials -> UserPass;

            $credentials = NULL;

            try {

                $this -> connection = new PDO( "mysql:host=".$this -> DBHost."; dbname=".$this -> DBName , $this -> UserLogin , $this -> UserPass );

            } catch( PDOException $e ) {

                echo $e->getMessage();

                //mail( "test@test.com", 'Database error message', $e->getMessage() );
                echo "Page actuellement indisponible";
                exit;

            }

        }

        function checkLogin( $mail, $password ) {

            $sth = $this -> connection -> prepare(
                "SELECT ID, _Mail, Localisation, _Password FROM Admins WHERE _Mail = ?",
                array( PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY )
            );

            $sth -> execute( array( $mail ) );
            $sth = $sth->fetch();

            // —— If no user are found, show error message
            if ( $sth ) {

                // —— Check salted password and compare it
                if ( $password === $sth["_Password"] ) {

                    return $sth;

                } else return 2;

            } else return 1;

        }

        function getAdmins( $local ) {

            $sth = $this -> connection -> prepare(
                "SELECT _Mail, ID, Localisation FROM Admins",
                array( PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY )
            );

            $sth -> execute( array( $local ) );

            return $sth->fetchAll();



        }

        function getCategory( ) {

            $sth = $this -> connection -> prepare(
                "SELECT * FROM Categories",
                array( PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY )
            );

            $sth->execute();

            if ( $sth )
                return $sth->fetchAll();

        }


        function generateQuestions( $categorie ) {

            $sth = $this -> connection -> prepare(
                "SELECT * FROM Questions WHERE Categorie = \"".$categorie["Nom"]."\" ORDER BY Obligatoire DESC, RAND() LIMIT ".$categorie["QuantiteMin"],
                array( PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY )
            );

            $sth->execute();

            return $sth->fetchAll();

        }

        function generateTest( $user ) {

            $token = md5( $user["name"].$user["firstName"].$user["birthDate"] );

            $sth = $this -> connection -> prepare(
                "INSERT INTO `Tests`(`_Token`, `Nom`, `Prenom`, `DateDeNaissance`, `Telephone`, `Mail`, `IDPEmploi`, `DateDebutDisp`, `DatefinDisp` )
                 VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ? )" );

            $sth->execute( array(
                $token,
                $user["name"],
                $user["firstName"],
                $user["birthDate"],
                $user["phone"],
                $user["mail"],
                $user["PoleEmploiID"],
                $user["StartDisp"] || null,
                $user["EndDisp"]  || null,
            ) );

            foreach ( $this->getCategory( ) as $categorie ) {

                foreach ( $this->generateQuestions( $categorie ) as $question ) {

                    $sth = $this -> connection -> prepare( "INSERT INTO `QuestionsTests`(`_Token`, `IDQuestion` ) VALUES ( '$token', ".$question['_ID'].")" );

                    $sth->execute();

                }

            }

        }

        function getTest( $token ) {

            $sth = $this -> connection -> prepare(
                "SELECT * FROM `QuestionsTests` INNER JOIN Questions WHERE QuestionsTests._Token = '$token' AND Questions._ID = QuestionsTests._ID",
                array( PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY )
            );

            $sth->execute();

            return $sth->fetchAll();

        }

    }

?>