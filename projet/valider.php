<?php
/*
*Créé le 21 Mars 2018, MT.
*Fichier de validation globale d'un formulaire, il permet d'avoir un récapitulatif des questions
*La page recoit $_GET['id_questionnaire'], $_GET["id_question"], $_GET["type"] et $_POST['message']
*Initialisation de la connexion de la base de donnée et vérification des erreurs en adéquation.
*Lancement de la session.
*Lancement de la fonction adéquate.
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
		<?php 	
				/*
				*Initialisation de la connexion de la base de donnée et vérification des erreurs en adéquation.
				*Lancement de la session.
				*/
				$info = GetTousId_questionRepondues($_SESSION['id']);
				$i = 0;
				while(isset($info[$i]))
				{
		?>
					<p>
						<strong>Question <?php echo $info[$i]; ?></strong> : <?php echo GetReponseReponse($_SESSION['id'], $info[$i]); ?><br />
					</p>
		<?php
					$i++;
				}				
		?>
    </body>
    <a href="choix.php">Retour questionnaires</a>
</html>
