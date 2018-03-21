<?php
session_start();
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

		//Affichage Prof\\
		//L'utilisateur est-il prof ?
		$requete = "SELECT prof FROM UTILISATEUR WHERE login = ?"; //Faudrait tout récup et mettre dans des variables session.
		$reponse = $bdd -> prepare($requete);
		$reponse -> execute(array($_SESSION['login']));
		$wait = $reponse -> fetch();
		$prof = $wait['prof'];
		$reponse->closeCursor();

		//S'il est prof alors afficher sa partie
		if($prof == 1)
		{
			$requete = "SELECT * FROM QUESTION WHERE id_questionnaire = ? ORDER BY id_question";
			$reponse = $bdd -> prepare($requete);
			$reponse -> execute(array($_GET['num']));
			echo 'Modifier:';			?>
				</br></br>
				<form action=update.php?type=update&amp;questionnaire=<?php echo $send ?> method="POST" >
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
				<form action=update.php?type=add&amp;questionnaire=<?php echo $send ?> method="POST" >
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
				<form action=update.php?type=delete&amp;questionnaire=<?php echo $send ?> method="POST" >
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
