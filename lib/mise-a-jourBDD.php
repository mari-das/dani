<?php
    include "../configuration/BDD.php";
    session_start();
    unset($_SESSION['message']);

    /*Note le produit choisi utilisant son identifiant*/
    $lid = $_GET['q'];
    $action = $_GET['action'];

    /*Sélectionne la table afin de le modifier plus facilement*/
    $sql = "SELECT * FROM livres_produits WHERE  ID= ".$lid;
    $req=$connexion->prepare($sql);

    $req->execute();
    $results=$req->fetchall(); 

    /*Place la quantité de produits disponible dans la variable $disponibilite*/
    $disponibilite = $results[0][5];
    
    /*Si la valeaur placée dans la variable est plus grand que 0 et le cookie pour le nom d'utilisateur existe, effectue le code*/
    if($disponibilite > 0 && isset($_SESSION["nom_utilisateur"])) {
        $nom_utilisateur=$_SESSION["nom_utilisateur"];

        /*Sélectionne la table emprunter afin de faire des modifications*/
        $sqlLivres = "SELECT * FROM emprunter";
        $reqLIVRES=$connexion->prepare($sqlLivres);
        $reqLIVRES->execute();
        $utilLivres=$reqLIVRES->fetchall(); 

        $utilisateurLivre = false;
        /*Vérifie si le numéro de l'identifiant (livre) existe dans la table et si le nom de l'utilisateur existe déjà dans la table*/
        for ($i=0; $i<count($utilLivres); $i++) {
            if ($utilLivres[$i][1] == $lid && $utilLivres[$i][2] == $nom_utilisateur) {
                $utilisateurLivre = true;
            }
        }
        /*Si la condition est fausse*/
        if (!$utilisateurLivre) {
            /*Réduit la quantité de produits disponible par 1*/
            if ($action == "enlever") {
                $disponibilite = $disponibilite - 1;
            }
            /*Fait le mise à jour à la table livres_produits*/
            $statement=$connexion->prepare("UPDATE livres_produits SET disponibilite = " .$disponibilite. " WHERE ID = ".$lid);
            $statement->execute();
            /*Insérer les  nouveaux informations dans la table emprunter*/
            if ($action == "enlever") {
                try{
                    $update=$connexion->prepare("
                            INSERT INTO emprunter (livre,utilisateur)
                            VALUES(:livre,:nom_utilisateur)");
                    $update->bindParam(':livre', $lid);
                    $update->bindParam(':nom_utilisateur', $nom_utilisateur);
                    $update->execute();
        
                } catch(PDOException $e){ 
                    echo "Échec de connexion : ".$e->getMessage();
                }
            }
        } else {
            /*Augment la quantité de produits disponible par 1*/
            $disponibilite = $disponibilite + 1;
            /*Fait le mise à jour à la table livres_produits*/
            $statement=$connexion->prepare("UPDATE livres_produits SET disponibilite = " .$disponibilite. " WHERE ID = ".$lid);
            $statement->execute();

            try{
                /*Élimine le rangée ayant les informations sur le livre retourné dans la table emprunter*/
                $update=$connexion->prepare("
                        DELETE FROM emprunter WHERE utilisateur = :nom_utilisateur AND livre = :livre");

                $update->bindParam(':livre', $lid);
                $update->bindParam(':nom_utilisateur', $nom_utilisateur);
                $update->execute();
            } catch(PDOException $e){ 
                echo "Échec de connexion : ".$e->getMessage();
            }
        }
        /*Apporte l'utilisateur à la page qu'il est déjà sur*/
        header("Location: " . $_SERVER['HTTP_REFERER']);
        
     } else {
        /*Apporte l'utilisateur à la page d'accueil et affiche le message d'erreur*/
        $_SESSION['message'] = "Erreur : Aucun livre disponible";
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
 
    
    
?>