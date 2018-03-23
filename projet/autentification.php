<?php
/*
*Créé le 21 Mars 2018, MT.
*Fichier d'autentification des utilisateurs.
*La page recoit $_POST['login'] et $_POST['password'].
*Si ID et MDP correct: le contenus des $_POST sont assignés aux $_SESSION et redirection vers choix.php
*Si MDP incorrect: Redirection vers la page Index.php avec l'affichage d'un message d'erreur
*Si ID inconnus: Redirection vers la page Index.php avec l'affichage d'un message de création de compte
*Initialisation de la connexion de la base de donnée et vérification des erreurs en adéquation.
*Lancement de la session.
*Réaction en fonction des données reçues.
*Le pseudo existe, alors on vérifie le mot de passe.
*Réaction en fonction des données reçues.
*Le pseudo n'existe pas, on créer le compte utilisateur.
*Puis on redirige vers la page index.php en passant un paramètre de création de compte "CompteCree" dans le liens.
*Modification: Date/Initiales/Choses_modifiées
*23 Mars 2018/MT/Ajout de protection htmlspecialchars()
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
$id_bdd = id_bdd();
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
*Réaction en fonction des données reçues.
*Le pseudo existe, alors on vérifie le mot de passe.
*/
// On récupère tout le contenu de la table utilisateur
$login_utilisateurs = GetTousLesUtilisateurs();

// On vérifie sur dans toute la base de donnée de l'utilisateur
$i = 0;
while(isset($login_utilisateurs[$i]))
{
	//Si le login transmit en $_POST["login"] existe ?
	if($login_utilisateurs[$i] == htmlspecialchars($_POST["login"]))
	//Si le login existe
	{
		//Si le password associé au pseudo est correct ?
		if(GetPasswordUtilisateur($login_utilisateurs[$i]) == htmlspecialchars($_POST["password"]))
		//Si le pseudo est correct alors connexion, assignation des valeurs de $_SESSION['login'] ainsi que $_SESSION['password'] et $_SESSION['id']. Enfin redirection vers choix.php
		{
			$utilisateur = new Utilisateur(GetIdUtilisateur($login_utilisateurs[$i]));
			InfoUserIntoSession($utilisateur -> getId(), $utilisateur -> getLogin(), $utilisateur -> getProf());
			header("Location: choix.php");
			exit;
		}
		//Si le password associé au pseudo est incorrect ?
		else
		//Si le password accocié au pseudo est incorrect alors on renvois l'utilisateur sur la page index.php en passant un paramètre d'erreur de connection "ErreurId" dans le liens.
		{
			header("Location: index.php?connexion=ErreurId");
			exit;
		}
	}
	$i++;
}

/*
*Réaction en fonction des données reçues.
*Le pseudo n'existe pas, on créer le compte utilisateur.
*Puis on redirige vers la page index.php en passant un paramètre de création de compte "CompteCree" dans le liens.
*/
AjouterUtilisateur(htmlspecialchars($_POST["login"]), htmlspecialchars($_POST["password"]), 0);
header("Location: index.php?connexion=CompteCree");
?>