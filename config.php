<?php

    // —— Définissez vos identifiant de connections

    // — Adresse de la base de données
    $DBHost     = "localhost";
    // — Nom de la table
    $DBName     = "gestion_questionnaires_rh";
    // — Identifiant de connexion
    $UserLogin  = "questionnaires_rh_user";
    // — Mot de passe
    $UserPass   = "uncafesvp";

    // —— Mail

    // $mailHost       = "smtp.example.com";
    // $mailTo         = "user@example.com";
    // $mailSMTPAuth   = true;
    // $mailUsername   = "user@example.com";
    // $mailPassword   = "secret";
    // $mailPort       = 465;

    $mailHost       = "smtp.gmail.com";
    $mailTo         = "geyinox144@herrain.com";
    $mailSMTPAuth   = true;
    $mailUsername   = "coriolistestrecrutement@gmail.com";
    $mailPassword   = "C0r10l1s";
    $mailPort       = 587;

    return array(
        $DBHost,
        $DBName,
        $UserLogin,
        $UserPass,

        $mailHost,
        $mailTo,
        $mailSMTPAuth,
        $mailUsername,
        $mailPassword,
        $mailPort,
    );

?>
