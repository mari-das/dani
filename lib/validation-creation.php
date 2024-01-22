<?php 
	include "../configuration/BDD.php";
	session_start();
	unset($_SESSION['message']);
	
	$nom_utilisateur=$_POST['nom_utilisateur'];			
	$motDePasse=$_POST['mot_de_passe'];
	$confirmMotDePasse=$_POST['confirm_mot_de_passe'];

	/*Sélectionne la table utilisateurs*/
	$sql = "SELECT nom_utilisateur, mot_de_passe FROM utilisateurs WHERE nom_utilisateur = :nom_utilisateur";
	$stmt = $connexion->prepare($sql);
	$stmt->bindParam(':nom_utilisateur', $nom_utilisateur, PDO::PARAM_STR);
	$stmt->execute();

	/*Place les informations venant de la table dans des variables pour les rendre plus faciles à utilisés*/
	$informationbdd = $stmt->fetch(PDO::FETCH_ASSOC);
	$nomVerification = $informationbdd['nom_utilisateur'];
	/*Si la valeur dans la variable $motDePasse n'est pas égale à celle-ci dans la variable $confirmMotDePasse, affiche le message d'erreur*/
	if ($motDePasse !== $confirmMotDePasse) {
		$_SESSION['message'] = 'Erreur : Écrivez le même mot de passe dans les deux champs';
		header("Location: ".$_SERVER['HTTP_REFERER']);
	} else if (strlen($motDePasse) < 5) {
	/*Si la valeur dans la variable $motDePasse est moins que 5 caractères, affiche le message d'erreur*/
		$_SESSION['message'] = 'Erreur : Mot De Passe est moins que 5 caractères';
		header("Location: ".$_SERVER['HTTP_REFERER']);
	} else if ($nom_utilisateur === $nomVerification) {
	/*Si la valeur dans la variable $nom_utilisateur est égale à celle-ci dans la variable $nomVerification, affiche le message d'erreur*/
		$_SESSION['message'] = "Erreur : Nom d'utilisateur existe déjà";
		header("Location: ".$_SERVER['HTTP_REFERER']);
	} else {
		try{
			/*Insère les informations dans la table utilisateurs*/
			$statement=$connexion->prepare("
				INSERT INTO utilisateurs (nom_utilisateur,mot_de_passe)
				VALUES(:nom_utilisateur,:motDePasse)");
			$statement->bindParam(':nom_utilisateur', $nom_utilisateur);
			$statement->bindParam(':motDePasse', md5($motDePasse));
			$statement->execute();
			/*Créer un cookie pour le nom d'utilisateur*/
			setcookie('nom_utilisateur', $nom_utilisateur, time()+365*24*3600, null, null, false, true);
			session_start();
			$_SESSION["nom_utilisateur"] = $nom_utilisateur;		

		} catch(PDOException $e){ 
			echo "Échec de connexion : ".$e->getMessage();
		}

		header("Location: ../index.php");
	}
?>