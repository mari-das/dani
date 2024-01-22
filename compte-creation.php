<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Compte Creation</title>
		<meta charset="utf-8">
		<meta http-equiv="Content-language" content="fr" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="" />
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
		<link rel="stylesheet" href="css/style.css" />
	</head>
	<body class="m-0 p-0">
		<?php include "partiels/entete.php"; ?>
		<?php include "partiels/error-message.php"; ?>

		<div class="conteneur">
			<h1>Créer un compte</h1>
			<!--Un formulaire qui envoy les informations donnés au fichier php suivant utilisant la méthode post lorsque l'utilisateur soumis les informations affect le bouton-->
			<form action="lib/validation-creation.php" method="post">
				<p>Nom d'utilisateur : <br /><input type="text" name="nom_utilisateur"></p>
				<p>Mot de passe : <br /><input type="password" name="mot_de_passe"></p>
				<p>Confirmer mot de passe : <br /><input type="password" name="confirm_mot_de_passe"></p>

				<p><input type="submit" value="Créer mon compte" class="btn btn-principal" /></p>
			</form>
		</div>
	</body>
</html>