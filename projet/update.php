<?php
/*
*Créé le 21 Mars 2018, MT.
*Fichier qui effectue les changements demandés par le fichier modifier.php
*La page recoit $_GET['type'] avec soit update, add ou delete, $_GET['idquestionnaire'] pour le numero du questionnaire et $_POST[valeur] avec des chiffres pour le texte à modifier.
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
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8" />
        <title>BDD</title>
    </head>

    <body>
		<?php
		//Affichage Prof\\
		//L'utilisateur est-il prof ?
		//S'il est prof alors afficher sa partie
			if($_SESSION['prof'] == 1)
			{
				if($_GET['type'] == 'update') //Modification questionnaire
				{
					$id_question = GetTousId_questionnQuestion($_GET['idquestionnaire']);
					$i = 0;
					while (isset($id_question[$i]))
					{
						UpdateQuestion($id_question[$i], $_POST[$id_question[$i]]);
						$i++;
					}
				}
				elseif ($_GET['type'] == 'add') //Ajout questionnaire
				{
					AjouterQuestion($_GET['idquestionnaire'], $_POST['add']);
				}
				elseif ($_GET['type'] == 'delete') //Suppression question
				{
					
					$id_question = GetTousId_questionnQuestion($_GET['idquestionnaire']);
					$i = 0;
					while (isset($id_question[$i]))
					{
						if(isset($_POST[$id_question[$i]]) && $_POST[$id_question[$i]] == 'on')
						{
							DeleteQuestion($id_question[$i]);
						}
						$i++;
					}
				}
				$baz = array("value" => $_GET['idquestionnaire']);
				header("Location: modifier.php?id_questionnaire={$baz['value']}");
				exit;
			}
			?>
    </body>
</html>
