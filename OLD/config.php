<?php
    class DBConfig {

        protected $DBName;
        protected $DBHost;
        protected $UserLogin;
        protected $UserPass;

        // —— Définissez vos identifiant de connections
        function Connection() {
            $this -> DBName     = "gestion_questionnaires_rh";
            $this -> DBHost     = "localhost";
            $this -> UserLogin  = "questionnaires_rh_user";
            $this -> UserPass   = "uncafesvp";
        }
    }
?>
