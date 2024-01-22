<!--Lorsque l'utilisateur clique sur le bouton, effectue le code dans la fonction montreDiv()-->
<button onclick="montreDiv()" class="btn btn-secondaire">
    <span style="display:flex;"><span class="material-symbols-outlined" style="margin-right:5px;font-size:15px">login</span> Connexion</span>
</button>
<div id="sign-modal" class="modale" data-open="false">
    <h2>Se Connecter</h2>
    <!--Créer le formulaire de connexion - envoie les informations avec la méthode post au fichier validation-connexion.php-->
    <form action="lib/validation-connexion.php" method="post">
        <p>Nom utilisateur : <br/><input type="text" name="nom_utilisateur"></p>
        <p>Mot de passe : <br/><input type="password" name="mot_de_passe"></p>

        <p><input type="submit" name="submit" value="Connecter" class="btn btn-principal" /></p>
    </form>
    <!--hyerlien qui envoie l'utilisateur à la page compte-creation.php pour créer leur propre compte-->
    <a href="compte-creation.php">Créer un compte</a>  
</div>
<script>
    function montreDiv() {
        const elm = document.getElementById('sign-modal');
        /*Lorsque l'attribut data-open contient la valeur fausse, ferme le petite fenêtre*/
        if (elm.getAttribute("data-open") === "false") {
            elm.style.display = "block";
            elm.setAttribute("data-open", "true");
        }else { /*Lorsque l'attribut data-open contient la valeur vrai, ouvre le petite fenêtre*/
            elm.style.display = "none";
            elm.setAttribute("data-open", "false");
        }
    }
</script>