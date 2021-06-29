<?php

    include "./config.php";

    class Mysql extends DbConfig {

        public $connection;
        public $dataSet;
        private $sqlQuery;

        protected $DBName;
        protected $DBHost;
        protected $UserLogin;
        protected $UserPass;

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
                "SELECT * FROM Question WHERE categorie = '".$categorie["Nom"]."' ORDER BY Obligatoire DESC, RAND() LIMIT ".$categorie["QuantiteMin"],
                array( PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY )
            );

            $sth->execute();

            return $sth;


        }

    }

?>