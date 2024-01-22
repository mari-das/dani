<?php
    /*Inclus le code venant du fichier php suivant - afin de connecter au compte de phpmyadmin*/
    include "configuration/BDD.php";
    session_start();
    /*Sélectionne la table livres_produits afin de s'afficher tous les produits*/
    $req=$connexion->prepare(
        "SELECT * FROM livres_produits" 
    );

    $req->execute();
    $results=$req->fetchall(); 
?>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-language" content="fr" />
    <title>Magasin En Ligne</title>
    <meta name="description" content="" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="css/style.css" />

</head>
<body class="p-0 m-0">
    <?php include "partiels/entete.php"; ?>
    <?php /*Inclus le code venant du fichier suivant - contrôle l'affectation des messages d'erreurs*/ include "partiels/error-message.php"; ?>
    <div class="conteneur">
        <?php 
            /*Si le cookie existe, effectue le code*/
            if (isset($_SESSION["nom_utilisateur"])) {
                echo "<br><h1>Bienvenue à notre Bibliothèque <em>".$_COOKIE['nom_utilisateur']." -- ".$_SESSION["nom_utilisateur"]."</em> !</h1><br>";
            }else{
                echo "<br><h1> Bienvenue à notre Bibliothèque 🎉</h1><br>";
            }
        ?>
        <p >Voici nos produits le plus populaire :</p>
    </div>

    <?php
        echo "<div class='conteneur'>";
            echo "<div class='flex' style='gap:12px;'>";
            /*Effectue le code suivant pour chaque produit dans la table livres_produits*/
            for ($i=0;$i<count($results);$i++) {
                echo "<div id='".$results[$i][0]."' class='carte'>";
                    echo "<div class='carte-image'>";
                    /*Si le lien pour l'image existe, affiche le*/
                    if ($results[$i][3] !== "") {
                        echo "<img src='".$results[$i][3]."' alt='' width='120px' height='185' />";
                    }else { /*Si le lien nexiste pas, affiche un image alternatif*/
                        echo "<img src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSrfATRB_UrZFHvy3TcnuiWJQUiHKSADdx0mGQ-X4nnUqx4lTzp7aSItFwvWObx9lI8TGY&usqp=CAU' alt='' width='150px' />";
                    } 
                    echo "</div>";
                    /*Affiche le nom du livre*/
                    echo "<h3 style='display:block;padding:0 12px;'>".$results[$i][1]."</h3>";
                    /*Affiche le nom de l'auteur*/
                    echo "<p style='display:block;padding:0 12px;'>".$results[$i][2]."</p>";
                    /*Créer le bouton ainsi que le query pour apporter l'utilisateur vers le produit qu'il a choisi*/
                    echo "<div style='padding:0 12px;margin-bottom:12px;'><a href='detail.php?q=".$results[$i][0]."' class='btn btn-principal btn-block'><em>Voir plus...</em></a></div>";
                echo "</div>";
            }
            echo "</div>";
        echo "</div>";
?>
</body>
</html>
