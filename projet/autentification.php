<?php

session_start();

	$id="crepinl";
	$mdp="1108010387S";
	$nsd="mysql:host=webinfo.iutmontp.univ-montp2.fr;dbname=crepinl;charset=UTF8";
	try
				{
					$bdd = new PDO($nsd,$id,$mdp);
				}
				catch (Exception $e)
				{
						die('Erreur : ' . $e->getMessage());
				}
				//Tests
				echo $_POST["login"];
				echo $_POST["password"];
				
				// On récupère tout le contenu de la table utilisateur
				$requete = "SELECT * FROM UTILISATEUR";
				$reponse = $bdd -> query($requete);


				//if($reponse==false)
				//exit("erreur PDO:query($requete)");
			
				while($donnees = $reponse->fetch())
				{
					echo $donnees['login'];
					echo $_POST['login'];
					echo $donnees['password'];
					echo $_POST['password'];
					if($donnees['login'] == $_POST["login"])
					{
						if($donnees['password'] == $_POST["password"]) //Si le pseudo existe dans la BDD, alors on vérfie le password
						{
							echo 'Tout valide';
							$_SESSION['id'] = $donnees['id_utilisateur']; //Si le password et pseudo sont bon, on récupère l'id
							$_SESSION['erreurId'] = 0;
							$_SESSION['compteCree'] = 0;
							$_SESSION['login'] = $_POST['login'];
							$_SESSION['password'] = $_POST['password'];
							header("Location: choix.php");
							exit;
						}else	//Si le password n'est pas bon, on met un message d'erreur à la page index.php
						{
							echo 'Pas bon mdp';
							$_SESSION['erreurId'] = 1;
							header("Location: index.php");
							exit;
						}
					}
				}
				$reponse->closeCursor();
				
				//Si le pseudo n'existe pas, on le créé avec le password
				echo 'Creation du compte';
				$req = $bdd->prepare("INSERT INTO UTILISATEUR(login, password) 
									VALUES(:login, :password)");
				$req->execute(array(
					'login' => $_POST['login'],
					'password' => $_POST['password'],
				));
				$_SESSION['compteCree'] = 1;
				header("Location: index.php");
?>

<!DOCTYPE html>


<html>
    <head>
        <meta charset="utf-8" />
        <title>BDD</title>
    </head>

    <body>
    </body>
</html>
