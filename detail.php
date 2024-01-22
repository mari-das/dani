<?php
    include "configuration/BDD.php";
    session_start();
    /*Place l'identifiant du livre dans la variable $lid*/
    $lid = $_GET['q'];
    /*Sélectionne la table livres_produits*/
    $req=$connexion->prepare(
        "SELECT * FROM livres_produits WHERE ID= ".$lid 
    );

    $req->execute();
    $results=$req->fetchall(); 

    /*Sélectionne la table emprunter*/
    $sqlLivres = "SELECT * FROM emprunter";
    $req=$connexion->prepare($sqlLivres);
    $req->execute();

    $utilLivres=$req->fetchall(); 
?>


<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-language" content="fr" />
    <title><?php echo $results[0][1] ?></title>
    <meta name="description" content="" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="css/style.css" />

</head>
<body class="p-0 m-0">
    <?php include "partiels/entete.php"; ?>
    <?php include "partiels/error-message.php"; ?>

    <div class="conteneur">
        <div class="flex" style="gap:25px;">
            <div style="margin-top:25px;">
                <?php 
                    /*Si l'image existe dans la table, affiche-le*/
                    if ($results[0][3] !== "") {
                        echo "<img src='".$results[0][3]."' alt='' width='250px' />";
                    }else { /*Si non, affiche l'image alternatif*/
                        echo "<img src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSrfATRB_UrZFHvy3TcnuiWJQUiHKSADdx0mGQ-X4nnUqx4lTzp7aSItFwvWObx9lI8TGY&usqp=CAU' alt='' width='250px' />";
                    } 
                ?>
            </div>
            <div>
                <?php 
                    /*Affiche le nom du livre*/
                    echo "<h1>".$results[0][1]."</h1>"; 
                    /*Affiche le nom de l'auteu*/
                    echo "<p><em>".$results[0][2]."</em></p>";
                    /*Affiche la description du livre*/
                    echo "<p>".$results[0][4]."</p>";
                    /*Affiche la quantité de livres disponibles*/
                    echo "<p>Disponible: ".$results[0][5]." livres</p>"; 
                    /*Si le cookie de l'utilisateur existe et il y a plus que 0 livres disponibles, effectue le code suivant*/
                    if ($results[0][5] > 0 && isset($_SESSION["nom_utilisateur"])) {
                        $nom_utilisateur=$_SESSION["nom_utilisateur"];
                        $utilisateurLivre = false;
                        /*Pour chaque élément dans la variable $utilLivres (la table emprunter), effectue le code */
                        for ($i=0; $i<count($utilLivres); $i++) {
                            /*Si l'identié du livre est égale à la valeur dans la variable $lid, et le nom d'utilisateur est égale à la valeur dans la variable $nom_utilisateur, effectue le code*/
                            if ($utilLivres[$i][1] == $lid && $utilLivres[$i][2] == $nom_utilisateur) {
                                $utilisateurLivre = true;
                            }
                        }
                        /*Si la variable $utilisateurLivre contient la booléenne fausse*/
                        if (!$utilisateurLivre) {
                            /*Le bouton montre le mot Emprunter et l'action est enlever*/
                            echo "<a href='lib/mise-a-jourBDD.php?q=".$lid."&action=enlever' class='btn btn-principal'>Emprunter</a>";
                        }else {
                            /*Le bouton montre le mot Retourner et l'action est adjuster*/
                            echo "<a href='lib/mise-a-jourBDD.php?q=".$lid."&action=adjuster' class='btn btn-principal'>Retourner</a>";
                        }
                    }
                ?>
            </div>
        </div>
    </div>

</body>
</html>