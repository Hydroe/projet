<?php
/*
*Créé le 21 Mars 2018, MT.
*Fichier d'enregistrement ou de modification d'une réponse de l'utilisateur
*La page recoit $_GET['id_questionnaire'].
*Initialisation de la connexion de la base de donnée et vérification des erreurs en adéquation.
*Lancement de la session.
*Vérifie s'il s'agit bien d'un utilisateur autorisé.
*Partie qui permet de modifier une ou des questions du formulaire.
*Partie qui permet d'ajouter une questions du formulaire.
*Partie qui permet de supprimer une ou des questions du formulaire
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
			/*
			*Partie qui permet de modifier une ou des questions du formulaire.
			*/
			$id_question = GetTousId_questionnQuestion($_GET['id_questionnaire']);
			echo 'Modifier:';
			echo $_GET['id_questionnaire'];
			?>
				</br></br>
				<form action=<?php echo "update.php?type=update&idquestionnaire=" .$_GET['id_questionnaire']; ?> method="POST" >
			<?php
			$i = 0;
			while (isset($id_question[$i]))
			{
				echo 'Question: ' .$id_question[$i] .' ' .GetTexteQuestion($id_question[$i]);
				?>
					</br>
					<textarea name="<?php echo $id_question[$i]; ?>" rows="4" cols="45" ><?php echo GetTexteQuestion($id_question[$i]);?></textarea>
					</br></br>
				<?php
				$i++;
			}
			?>
				<p><input type="submit" name="valider" value="Valider votre modification/Supprimer" href=""></p>
			</form>
			<?php
			/*
			*Partie qui permet d'ajouter une questions du formulaire.
			*/
			echo 'Ajouter:'

			?>
				</br></br>
				<form action=update.php?type=add&amp;idquestionnaire=<?php echo $_GET['id_questionnaire'] ?> method="POST" >
					<textarea name="add" rows="4" cols="45" >Ajoutez votre question</textarea>
					<p><input type="submit" name="valider" value="Valider votre ajout" href=""></p>
				</form>
				</br></br>
			<?php

			/*
			*Partie qui permet de supprimer une ou des questions du formulaire.
			*/
			echo 'Supprimer:';

			?>
				</br></br>
				<form action=update.php?type=delete&amp;idquestionnaire=<?php echo $_GET['id_questionnaire'] ?> method="POST" >
			<?php

			$i = 0;
			while (isset($id_question[$i]))
			{
				?>
					<input type="checkbox" name="<?php echo $id_question[$i] ?>" id="<?php echo $id_question[$i] ?>" /> <label for="<?php echo $id_question[$i] ?>">Question <?php echo $id_question[$i] ?></label><br />
				<?php
				$i++;
			}
			?>
				<input type="submit" value="Supprimer">
				</form>
				</br></br>
			<?php
		}
			?>
    </body>
</html>
