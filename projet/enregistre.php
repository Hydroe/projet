<?php
/*
*Créé le 21 Mars 2018, MT.
*Fichier d'enregistrement ou de modification d'une réponse de l'utilisateur
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

/*
*Lancement de la fonction adéquate.
*Si type=add on ajoute dans la bdd
*Si type=update on modifie la bdd
*/
if ($_GET['type'] == "add")
{
	AjouterReponse($_SESSION['id'], $_GET['id_question'], $_POST['message']);
}
elseif ($_GET['type'] == "update")
{
	UpdateReponse($_SESSION['id'], $_GET['id_question'], $_POST['message']);
}
header("Location: formulaire1.php?id_questionnaire=".$_GET["id_questionnaire"]."&id_question=".$_GET["id_question"]);
exit;
?>