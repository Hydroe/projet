<?php
/*
*Créé le 21 Mars 2018, MT.
*Fichier d'enregistrement ou de modification d'une réponse de l'utilisateur
*La page recoit $_GET['id_questionnaire']
*Initialisation de la connexion de la base de donnée et vérification des erreurs en adéquation.
*Lancement de la session.
*Vérifie s'il s'agit bien d'un utilisateur autorisé.
*Modification: Date/Initiales/Choses_modifiées
*22 Mars 2018/MT/Modification de Enregistrer la réponse, avec différentiation de l'add et de l'update.
*
*
*/

/*
*Initialisation de la connexion de la base de donnée et vérification des erreurs en adéquation.
*Lancement de la session.
*/
//Appel du fichier contenant les variables
require_once('fonction.php');
require_once('utilisateur.php');
$id_bdd = Id_bdd();
//Vérification de la connexion à la bdd
try
{
	$bdd = new PDO($id_bdd['nsd'],$id_bdd['id'],$id_bdd['mdp']);
}
catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}

$_SESSION['question'] = 1;
$i = 0;
$send = $_GET['num'];
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8" />
        <title>BDD</title>
    </head>

    <body>
			<?php
		/*
		*Vérifie s'il s'agit bien d'un utilisateur autorisé.
		*/
		if($_SESSION['prof'] == 1)
		{
			$requete = "SELECT * FROM QUESTION WHERE id_questionnaire = ? ORDER BY id_question";
			$reponse = $bdd -> prepare($requete);
			$reponse -> execute(array($_GET['num']));
			echo 'Modifier:';			
			?>
				</br></br>
				<form action=update.php?type=update&amp;questionnaire=<?php echo $_GET['num'] ?> method="POST" >
			<?php

			while ($donnees = $reponse->fetch())
			{
				echo 'Question: ';
				echo $donnees['id_question'];
				echo ' ';
				echo $donnees['texte'];
				$coch = $donnees['id_question'] * 9999;
				?>
					</br>
					<textarea name="<?php echo $donnees['id_question'] ?>" rows="4" cols="45" ><?php echo $donnees['texte']?></textarea>
					</br></br>
				<?php
			}
			$reponse->closeCursor();
			?>
				<p><input type="submit" name="valider" value="Valider votre modification/Supprimer" href=""></p>
			</form>
			<?php

			echo 'Ajouter:'

			?>
				</br></br>
				<form action=update.php?type=add&amp;questionnaire=<?php echo $_GET['num'] ?> method="POST" >
					<textarea name="add" rows="4" cols="45" >Ajoutez votre question</textarea>
					<p><input type="submit" name="valider" value="Valider votre ajout" href=""></p>
				</form>
				</br></br>
			<?php

			echo 'Supprimer:';

			$requete = "SELECT * FROM QUESTION WHERE id_questionnaire = ? ORDER BY id_question";
			$reponse = $bdd -> prepare($requete);
			$reponse -> execute(array($_GET['num']));

			?>
				</br></br>
				<form action=update.php?type=delete&amp;questionnaire=<?php echo $_GET['num'] ?> method="POST" >
			<?php

			while ($donnees = $reponse->fetch())
			{
				?>
					<input type="checkbox" name="<?php echo $donnees['id_question'] ?>" id="<?php echo $donnees['id_question'] ?>" /> <label for="<?php echo $donnees['id_question'] ?>">Question <?php echo $donnees['id_question'] ?></label><br />
				<?php
			}
			$reponse->closeCursor();
			?>
				<input type="submit" value="Supprimer">
				</form>
				</br></br>
			<?php
		}
			?>
    </body>
</html>
