<?php

/*
*Créé le 21 Mars 2018, MT.
*Fichier index. Base du site
*Modification: Date/Initiales/Choses_modifiées
*ex:(23 Mars 2018/MT/Création des commentaires)
*
*
*/

/*
*Initialisation de la connexion de la base de donnée et vérification des erreurs en adéquation.
*Lancement de la session.
*/
//Appel du fichier contenant les variables
require_once('fonction.php');
$id_bdd = id_bdd();
//Vérification de la connexion à la bdd
try
{
	$bdd = new PDO($id_bdd['nsd'],$id_bdd['id'],$id_bdd['mdp']);
}
catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}


/*
*Création des variables sessions utiles.
*login -> login de l'utilisateur
*password -> password de l'utilisateur
*id -> id de l'utilisateur dans la base de donnée
*/
$_SESSION['login'] = 'invalide';
$_SESSION['password'] = 'invalide';
$_SESSION['id'] = 0;

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>BDD</title>
        <link rel="stylesheet" href="css/styles.css">
    </head>

    <!-- Interface de connexion
    -Permet l'identification
    -Renvoie sur la page autentification.php
    -Renvoie $_POST['login'] et $_POST['password']
    -->
    <body>
		<div id="header">
			<h1>Login Elève Projet</h1>
			<h2>AS - IUT Montpellier</h2>
		</div>
		<form action="autentification.php" method="POST">
			<div class="group">
				<input type="text" name="login">
				<label>Login </label>
			</div>
			<div class="group">
				<input type="text" name="password">
				<label>Password </label>
			</div>
			<p><input class="login buttonBlue" type="submit"></p>
		</form>
		
		<!-- Renvois d'informations
    	-Permet à l'utilisateur de voir s'il a créer un compte ou si ses identifiants sont inccorects 
    	-Regarde s'il reçoit $_GET['connexion'] dans l'URL. Si oui il affiche l'information, Si non alors n'affiche rien.
    	-Si reception de ErreurId alors affiche "Mot de passe incorrect.". Si reception de CompteCree alors affiche "Compte créé, vous pouvez vous connecter.".
    	-->
		<p><?php
			if (isset($_GET['connexion'])) {
				if($_GET['connexion'] == 'ErreurId')
				{
					echo 'Mot de passe incorrect.';
				}
				if($_GET['connexion'] == 'CompteCree')
				{
					echo 'Compte créé, vous pouvez vous connecter.';
				}
			}
			
		?></p>
		 <footer><a href="https://material.io/guidelines/" target="_blank"><img src="ressources/material.png"></a>
		<p>Google <a href="https://material.io/guidelines/" target="_blank">Material Design</a></p>
		<script type="text/javascript" src="js/jquery-3.2.1.js"></script>
  <script type="text/javascript" src="js/scripts.js"></script>
    </body>
</html>
