<?php
	include "../configuration/BDD.php";
	session_start();
	unset($_SESSION['message']);

	/*Si les deux champs sont remplis, effectue le code*/
	if (trim(isset($_POST['nom_utilisateur'])) && trim(isset($_POST['mot_de_passe']))) {
	    /*Sélectionne la table utilisateur*/
		$sql = "SELECT nom_utilisateur, mot_de_passe FROM utilisateurs WHERE nom_utilisateur = :nom_utilisateur";
	    $stmt = $connexion->prepare($sql);
	    $stmt->bindParam(':nom_utilisateur', $_POST['nom_utilisateur'], PDO::PARAM_STR);
	    $stmt->execute();

		/*Place les informations venant de la table dans des variables - une pour les mots de passe, une pour les identifiants*/
	    $informationbdd = $stmt->fetch(PDO::FETCH_ASSOC);
		$nom_utilisateur = $informationbdd['nom_utilisateur'];
	    $passe = $informationbdd['mot_de_passe'];
		/*Si les informations dans les boîtes de texte sont exactement le même que les valeurs dans la table, effectue le code*/
    	if ($nom_utilisateur === $_POST['nom_utilisateur'] && $passe === md5($_POST['mot_de_passe'])) {
	        /*Créer un cookie pour être utilisé plus tard*/
			setcookie('nom_utilisateur', $nom_utilisateur);
			session_start();
			$_SESSION["nom_utilisateur"] = $nom_utilisateur;
			/*Apporte l'utilisateur sur la page qu'il est déjà sur*/
	        header("Location: " . $_SERVER['HTTP_REFERER']);
			
		} else {
			/*Affiche le message d'erreur si soit le nom d'utilisateur, ou le mot de passe est incorrect*/
			$_SESSION['message'] = "Erreur : Le nom d'utilisateur et/ou le mot de passe ne sont pas corrects";
			header("Location: " . $_SERVER['HTTP_REFERER']);
    	}
    } else {
		/*Affiche le message d'erreur si le/les champs ne sont pas remplis*/
		$_SESSION['message'] = 'Erreur : Remplie les deux champs';
		header("Location: " . $_SERVER['HTTP_REFERER']);
	}
?>