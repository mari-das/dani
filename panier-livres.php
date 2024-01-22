<?php
    include "configuration/BDD.php";
    session_start();
    /*Si le cookie pour l'utilisateur existe, effectue le code*/
    if(isset($_SESSION["nom_utilisateur"])) {
        /*Place le cookie dans une variable*/
        $nom_utilisateur=$_SESSION["nom_utilisateur"];
        /*Sélectionne toute la table emprunter*/
        $sql = "SELECT * FROM emprunter";
        $req=$connexion->prepare($sql);
        $req->execute();
        $results=$req->fetchall(); 
        /*Sélectionne toute la table livres_produits*/
        $sqlLIVRES = "SELECT * FROM livres_produits";
        $reqLIVRES=$connexion->prepare($sqlLIVRES);
        $reqLIVRES->execute();
        $resultsLIVRES=$reqLIVRES->fetchall(); 

        $panier = array();

        for ($i=0; $i<count($results); $i++) {
            if ($results[$i][2] == $nom_utilisateur) {
                for ($x=0; $x<count($resultsLIVRES); $x++) {
                    if ($results[$i][1] == $resultsLIVRES[$x][0]) {
                        array_push($panier, $resultsLIVRES[$x]);
                    }
                }
            }
        }
    } else {
       header("Location: index.php");
    }
 
?>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-language" content="fr" />
    <title>Magasin En Ligne</title>
    <meta name="description" content="" />
    <link rel="icon" href="https://phpsandbox.io/assets/img/brand/phpsandbox.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="css/style.css" />

</head>
<body class="p-0 m-0">
    <?php include "partiels/entete.php"; ?>
    <div class="conteneur">
        <h1>Voici les livres que t'avais emprunté <?php echo "<em>".$_COOKIE['nom_utilisateur']." -- ".$_SESSION["nom_utilisateur"]."</em>"; ?></h1>
        <?php
            echo "<div class='conteneur'>";
                if(count($panier) == 0) {
                    echo "Tu n'as pas emprunter des livres.";
                } else {
                    echo "<div>";
                        for ($i=0; $i<count($panier); $i++) {
                            echo "<div class='carte carte-grande flex' style='gap:50px;align-items:center;'>
                                    <div class='carte-image'>";
                                    if ($panier[$i][3] !== "") {
                                        echo "<img src='".$panier[$i][3]."' alt='' width='120px' />";
                                    }else {
                                        echo "<img src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSrfATRB_UrZFHvy3TcnuiWJQUiHKSADdx0mGQ-X4nnUqx4lTzp7aSItFwvWObx9lI8TGY&usqp=CAU' alt='' width='120px' />";
                                    } 
                                echo "</div>";
                            echo "<div class='flex' style='justify-content:space-between;width:66%;'>";
                                echo "<div>
                                        <h2 class='m-0'>".$panier[$i][1]."</h2>
                                        <p class='m-0'style='margin-bottom:12px'><em>".$panier[$i][2]."</em></p>
                                    </div>";
                                echo "<div>
                                        <a href='lib/mise-a-jourBDD.php?q=".$panier[$i][0]."&action=adjuster' class='btn btn-principal'>Retourner</a>
                                    </div>";
                            echo "</div>";
                            
                            echo "</div>";
                            // echo "<br><li>".$panier[$i][1]."</li>";  
                        }
                    echo "</div>";
                }
            echo "</div>";  
        ?>
    </div>

</body>
</html>