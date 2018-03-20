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
				echo 'Est prof ';
				if($_GET['type'] == 'update')
				{
					echo 'Entre dans if';
					$requete = "SELECT * FROM QUESTION WHERE id_questionnaire = ? ORDER BY id_question";
					$reponse = $bdd -> prepare($requete);
					$reponse -> execute(array($_GET['questionnaire']));

					while ($donnees = $reponse->fetch())
					{
							$req = $bdd->prepare('UPDATE QUESTION SET texte = :Q WHERE id_question = num_q');
							$req->execute(array(
								'Q' => $_POST[{$donnees['id_question']}],
								'num_q' => $donnees['id_question']
								)
							);
					}
					$baz = array("value" => $_GET['questionnaire']);
					echo $_GET['questionnaire'];
					echo $baz['value'];
					//header("Location: modifier.php?num={$baz['value']}");
					//exit;
					$reponse->closeCursor();
				}
			}
			?>
    </body>
</html>
