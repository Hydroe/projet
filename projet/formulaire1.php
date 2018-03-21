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
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>BDD</title>
    </head>

    <body>
		<h1><?php echo htmlspecialchars($_SESSION['login']) . ' ' . htmlspecialchars($_SESSION['password']);?></h1>
		<?php
				$requete="SELECT * FROM QUESTION WHERE id_questionnaire ={$_GET["id_questionnaire"]} and id_question={$_GET["id_question"]}";
				$resultat=$bdd->query($requete);
				$questions=$resultat->fetchObject();
				echo "Question ".$questions -> id_question." :\"".$questions -> texte."\"</a>"."</li>";
		?>
		<?php
				//On compte le nombre total de questions (à terme, à mettre au début de la création session (index.php)) ou plus simplement à récupérer dans la table
				$reponse = $bdd->prepare('SELECT COUNT(*) AS nbQuestions FROM QUESTION WHERE id_questionnaire = ?');
				$reponse->execute(array(1));
		
				$donnees = $reponse->fetch();
				$nbQuestions = $donnees['nbQuestions'];
				$reponse->closeCursor();
				
				//verification s'il y a déjà une réponse
				$requete="SELECT COUNT(*) nb FROM REPONSE WHERE id_utilisateur =".$_SESSION['id']." and id_question={$_GET["id_question"]}";
				$resultat=$bdd->query($requete);
				$questions=$resultat->fetchObject();
				if($questions->nb==0){
					$texte="Saisissez votre réponse";
				}else{
					$requete="SELECT * FROM REPONSE WHERE id_utilisateur =".$_SESSION['id']." and id_question={$_GET["id_question"]}";
					$resultat=$bdd->query($requete);
					$questions=$resultat->fetchObject();
					$texte=$questions->reponse;
				}
		?>
		</br>
		<?php
			$reponse = $bdd->prepare('SELECT * FROM QUESTION WHERE id_questionnaire = ?');
			$reponse->execute(array(1));
		?>
		<form action=<?php echo "enregistre.php?id_questionnaire=".$_GET["id_questionnaire"]."&id_question=".$_GET["id_question"] ?> method="POST">
			<textarea name="message" rows="8" cols="45" ><?php echo $texte ?></textarea>
			<p><input type="submit" name="valider" value="Valider" href=""></p>
		</form>
			<form action="choix.php">
				<p><input type="submit" name="Fin questionnaire" value="Fin"p>
			</form>
    </body>
</html>