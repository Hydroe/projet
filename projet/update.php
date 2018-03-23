<?php
session_start();
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

				global $bdd;
				

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
				if($_GET['type'] == 'update') //Modification questionnaire
				{
					$requete = "SELECT * FROM QUESTION WHERE id_questionnaire = ? ORDER BY id_question";
					$reponse = $bdd -> prepare($requete);
					$reponse -> execute(array($_GET['questionnaire']));

					while ($donnees = $reponse->fetch())
					{
						$tamp = $donnees['id_question'];
						$req = $bdd->prepare('UPDATE QUESTION SET texte = :Q WHERE id_question = :num_q');
						$req -> execute(array(
							'Q' => $_POST[$tamp],
							'num_q' => $donnees['id_question']
							));
					}
					$reponse->closeCursor();
				}
				elseif ($_GET['type'] == 'add') //Ajout questionnaire
				{
					$req = $bdd->prepare("INSERT INTO QUESTION(id_questionnaire, texte) 
									VALUES(:id_questionnaire, :texte)");
					$req->execute(array(
						'id_questionnaire' => $_GET['questionnaire'],
						'texte' => $_POST['add'],
					));
				}
				elseif ($_GET['type'] == 'delete') //Suppression question
				{
					
					$requete = "SELECT * FROM QUESTION WHERE id_questionnaire = ? ORDER BY id_question";
					$reponse = $bdd -> prepare($requete);
					$reponse -> execute(array($_GET['questionnaire']));

					while ($donnees = $reponse->fetch())
					{
						$tamp = $donnees['id_question'];
						if(isset($_POST[$tamp]) && $_POST[$tamp] == 'on')
						{
							$req = $bdd->exec('DELETE FROM QUESTION WHERE id_question='.$tamp.' ');
							echo $tamp;
							echo 'S';
						}
					}
					$reponse->closeCursor();
				}
				$baz = array("value" => $_GET['questionnaire']);
				header("Location: modifier.php?num={$baz['value']}");
				exit;
			}
			?>
    </body>
</html>
