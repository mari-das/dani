<header style="">
    <div class="conteneur">
        <a href="index.php">Accueil</a>
        <?php 
            /*Si le cookie contenant le nom d'utilisateur existe, effectue le code*/
            if (isset($_SESSION["nom_utilisateur"])) { // $_COOKIE['nom_utilisateur']
                /*Créer un bouton qui apporte l'utilisateur vers le fichier validation-logout.php*/
                echo "<a href='lib/validation-logout.php' class='btn btn-secondaire'>Déconnexion</a>";
                /*Créer un bouton qui apporte l'utilisateur vers le fichier panier-livres.php*/
                echo "<a href='panier-livres.php'>Mes livres</a>";
            }else {
                /*Créer un bouton qui apporte l'utilisateur vers le fichier creation-compte.php*/
                include "partiels/creation-compte.php";
            }
        ?>
    </div>
</header>