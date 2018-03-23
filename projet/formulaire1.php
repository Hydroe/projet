<?php
/*
*Créé le 21 Mars 2018, MT.
*Fichier de réponse au question
*La page recoit $_GET['id_questionnaire'] et $_GET["id_question"]
*Initialisation de la connexion de la base de donnée et vérification des erreurs en adéquation.
*Lancement de la session.
*Vérifier si la question à déjà une réponse de l'utilisateur.
*Enregistrer la réponse.
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
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>BDD</title>
    </head>

    <body>
		<h1><?php echo htmlspecialchars($_SESSION['login']);?></h1>
		<?php
/*
*Vérifier si la question à déjà une réponse de l'utilisateur.
*Si non alors afficher "Saisissez votre réponse".
*Si oui alors afficher la réponse déjà saisie.
*/
			echo "Question ".GetNumero_questionQuestion($_GET['id_question'])." :\"".GetTexteQuestion($_GET['id_question'])."\"</a>"."</li>";
				
				//verification s'il y a déjà une réponse
				if(VerifierSiDejaReponse($_SESSION['id'], $_GET['id_question'])==0){
					$texte="Saisissez votre réponse";
				}else{
					$texte = GetTexteReponse($_SESSION['id'], $_GET['id_question']);
				}
		SautLigneDansPhp(1);

/*
*Enregistrer la réponse.
*Si il y a déjà une réponse alors il s'agit d'une modification, redirection vers enregistre.php avec comme paramètre l'id_questionnaire, l'id_question ainsi que type = update.
*Si il n'y a pas de réponse alors il s'agit d'un ajout, redirection vers enregistre.php avec comme paramètre l'id_questionnaire, l'id_question ainsi que type = add.
*/
		?>
		<form action=<?php echo $adresse = (VerifierSiDejaReponse($_SESSION['id'], $_GET['id_question'])==0) ? "enregistre.php?id_questionnaire=".$_GET['id_questionnaire']."&amp;id_question=".$_GET['id_question']."&amp;type=add" : "enregistre.php?id_questionnaire=".$_GET['id_questionnaire']."&amp;id_question=".$_GET['id_question']."&amp;type=update" ; ?> method="POST">
			<textarea name="message" rows="8" cols="45" ><?php echo $texte ?></textarea>
			<p><input type="submit" name="valider" value="Valider" href=""></p>
		</form>
			<form action="choix.php">
				<p><input type="submit" name="Fin questionnaire" value="Fin"p>
			</form>
    </body>
</html>