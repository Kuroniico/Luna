<?php
    class DBConfig {

        protected $DBName;
        protected $DBHost;
        protected $UserLogin;
        protected $UserPass;

        // —— Définissez vos identifiant de connections
        function Connection() {
            $this -> DBName     = "gestion_questionnaire_rh";
            $this -> DBHost     = "localhost";
            $this -> UserLogin  = "root";
            $this -> UserPass   = "root";
        }
    }
?>
