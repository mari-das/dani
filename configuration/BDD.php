<?php 
	/*Les information nécessaire pour connecter au compte phpmyadmin*/
	$db='sql5678375';
	$host='sql5.freemysqlhosting.net';
	$login='sql5678375';
	$pw='57qPCVFRGf';

	try {
    	$connexion = new PDO("mysql:host=$host;dbname=$db;charset=UTF8", $login, $pw);
	} catch (PDOException $e) {
    	echo "Échec de connexion : " . $e->getMessage();
	}
?>