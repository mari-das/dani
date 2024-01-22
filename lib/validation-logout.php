<?php
    /*Détruit tout les cookies présents et apporte l'utilisateur à la page qu'il est déjà sur*/
    session_start();

    unset($_SESSION["nom_utilisateur"]);

    header("Location: " . $_SERVER['HTTP_REFERER'])
?>