<?php
/*
*Créé le 21 Mars 2018, MT.
*Fichier fonction à utiliser dans les différents pages.
*Utiliser require('fonction.php'); pour appeler le fichier.
*include va réécrire alors que require va chercher dans le fichier.
	-Id-bdd / Fonction initialisation de la bdd et ouverture de session
	-SautLignedansPhp 						/ Fonction saut de ligne par </br>
	-InfoUserIntoSession 					/ Fonction de remplissage des informations de $_SESSION
	-CompteNbTuples		 					/ Fonction pour compter le nombre de tuples d'un questionnaire.
	-CompteNbQuestion 						/ Fonction pour compter le nombre de questions d'un formulaire précis.
	-CompteNbReponse 						/ Fonction pour compter le nommbre de réponse aux question d'un formulaire précis, faites par un utilisateur précis.
	-GetTousId_questionnaireQuestionnaire	/ Fonction qui renvoie tous les id_questionnaire du tableau QUESTIONNAIRE.
	-GetNomQuestionnaire					/ Fonction qui renvoie le nom du questionnaire ciblé.
	-GetDescriptionQuestionnaire			/ Fonction qui renvoie la description du questionnaire ciblé.
	-GetTousId_questionnQuestion 			/ Fonction qui renvoie tous les id_question en fonction de l'id_questionnaire choisie.
	-GetNumero_questionQuestion				/ Fonction qui renvoie le numéro de la question ciblée.
	-GetTexteQuestion						/ Fonction qui renvoie le texte de la question ciblée.
	-VerifierSiDejaReponse					/ Fonction qui renvoie si la question à déja une réponse.
	-AjouterReponse							/ Fonction qui ajoute une réponse à la bdd.
	-UpdateReponse							/ Fonction qui met à jour un réponse de la bdd.
	-GetTousLesUtilisateurs					/ Fonction qui renvoie tous les utilisateurs.
	-GetPasswordUtilisateur					/ Fonction qui renvoie le password de l'utilisateur.
	-GetIdUtilisateurs						/ Fonction qui renvoie le password de l'utilisateur.
	-AjouterUtilisateur						/ Fonction enregistre un utilisateur.
	-GetTousId_questionRepondues			/ Fonction renvoie les numero des questions répondues par l'utilisateur.
	-GetReponseReponse   					/ Fonction renvoie la réponse d'une question.
	-UpdateQuestion 						/ Fonction renvoie la réponse d'une question.
	-*AjouterQuestion						/ Fonction qui ajoute une question à la bdd.
	-
*Modification: Date/Initiales/Choses_modifiées
*22 Mars 2018/MT/Ajout fonctions: CompteNbQuestion, CompteNbQuestion, CompteNbReponse, GetTousId_questionnaireQuestionnaire, GetNomQuestionnaire, GetDescriptionQuestionnaire, GetTousId_questionnQuestion, GetNumero_questionQuestion, GetTexteQuestion, VerifierSiDejaReponse, AjouterReponse, UpdateReponse, GetTousLesUtilisateurs, GetPasswordUtilisateur, GetIdUtilisateurs
*23 Mars 2018/MT/Ajout fonctions: AjouterUtilisateur, GetTousId_questionRepondues, GetReponseReponse, UpdateQuestion, AjouterQuestion
*
*/



/*
*Fonction initialisation de la bdd et ouverture de session.
*On réunit ici les id mdp et nsd, si un paramètre change, alors le changement ne doit ce faire que ici.
*/
function Id_bdd()
{
	//Création de session
	session_start();

	//Initialisation des variables pour l'initialisation de la bdd
	$id_bdd = array (
    'id' => 'crepinl',
    'mdp' => '1108010387S',
    'nsd' => 'mysql:host=webinfo.iutmontp.univ-montp2.fr;dbname=crepinl;charset=UTF8');
    return $id_bdd;
}

/*
*Fonction saut de ligne par </br>.
*$nombre à remplir par le nombre de fois que l'on veut sauter de ligne.
*Cette fonction éviter d'écrire ) chaque fois ?></br><?php avec le nombre de </br> correspondant aux lignes.
*/
function SautLigneDansPhp($nombre)
{
	for ($i=0; $i < $nombre; $i++)
	{ 
		echo '</br>';
	}
}

/*
*Fonction de remplissage des informations de $_SESSION.
*$_SESSION['login'] pour le login de l'utilisateur;
*$_SESSION['prof'] pour le rang de l'utilisateur;
*$_SESSION['id'] pour l'id de l'utilisateur;
*/
function InfoUserIntoSession($id, $login, $prof)
{
	$_SESSION['login'] = $login;
	$_SESSION['prof'] = $prof;
	$_SESSION['id'] = $id;
}

/*
*Fonction pour compter le nombre de tuples d'un questionnaire.
*Reçoit le nom de la table.
*Renvoie le nombre de tuples.
*/
function CompteNbTuples($nom)
{
	global $bdd;
	$nb = $bdd->query('SELECT COUNT(*) AS nbQuestionnaires FROM QUESTIONNAIRE =' .$nom);
	$don = $nb->fetchObject();
	$nb2 = $don->nbQuestionnaires;
	$nb->closeCursor();
	return $nb2;
}

/*
*Fonction pour compter le nombre de questions d'un formulaire précis.
*Reçoit l'id du questionnaire.
*Renvoie le nombre de question correspondantes au questionnaire.
*/
function CompteNbQuestion($id_questionnaire)
{
	global $bdd;
	$nb = $bdd->query('SELECT COUNT(*) AS nbQuestions FROM QUESTION WHERE id_questionnaire = '.$id_questionnaire);
	$don = $nb->fetchObject();
	$nb2 = $don->nbQuestions;
	$nb->closeCursor();
	return $nb2;
}

/*
*Fonction pour compter le nommbre de réponse aux question d'un formulaire précis, faites par un utilisateur précis.
*Reçoit l'id du questionnaire.
*Renvoie le nombre de question correspondantes au questionnaire.
*/
function CompteNbReponse($id_questionnaire, $id_utilisateur)
{
	global $bdd;
	$nb = $bdd->query('SELECT COUNT(*) AS nbReponses FROM REPONSE JOIN QUESTION ON QUESTION.id_question=REPONSE.id_question WHERE id_questionnaire = '.$id_questionnaire.' AND id_utilisateur = '.$id_utilisateur);
	$don = $nb->fetchObject();
	$nb2 = $don->nbReponses;
	$nb->closeCursor();
	return $nb2;
}

/*
*Fonction qui renvoie tous les id_questionnaire du tableau QUESTIONNAIRE.
*Ne reçoit rien.
*Renvoie un tableau avec les iq_questionnaire.
*/
function GetTousId_questionnaireQuestionnaire()
{
	global $bdd;
	$i = 0;
	$rep = $bdd -> query("SELECT id_questionnaire FROM QUESTIONNAIRE");
	while ($don = $rep->fetch())
	{
		$id[$i] = $don['id_questionnaire'];
		$i++;
	}
	$rep->closeCursor();
	return $id;
}

/*
*Fonction qui renvoie le nom du questionnaire ciblé.
*Recoit d'id_questionnaire.
*Renvoie le nom du questionnaire.
*/
function GetNomQuestionnaire($id_questionnaire)
{
	global $bdd;
	$rep = $bdd -> query('SELECT nom FROM QUESTIONNAIRE WHERE id_questionnaire='.$id_questionnaire);
	$don = $rep->fetchObject();
	$rep2 = $don->nom;
	$rep->closeCursor();
	return $rep2;
}
/*
*Fonction qui renvoie la description du questionnaire ciblé.
*Recoit d'id_questionnaire.
*Renvoie la description du questionnaire.
*/
function GetDescriptionQuestionnaire($id_questionnaire)
{
	global $bdd;
	$rep = $bdd -> query('SELECT description FROM QUESTIONNAIRE WHERE id_questionnaire='.$id_questionnaire);
	$don = $rep->fetchObject();
	$rep2 = $don->description;
	$rep->closeCursor();
	return $rep2;
}

/*
*Fonction qui renvoie tous les id_question en fonction de l'id_questionnaire choisie.
*Reçoit l'id_questionnaire.
*Renvoie un tableau avec les iq_questionn.
*/
function GetTousId_questionnQuestion($id_questionnaire)
{
	global $bdd;
	$i = 0;
	$rep = $bdd -> query("SELECT id_question FROM QUESTION WHERE id_questionnaire =" .$id_questionnaire);
	while ($don = $rep->fetch())
	{
		$id[$i] = $don['id_question'];
		$i++;
	}
	$rep->closeCursor();
	return $id;
}

/*
*Fonction qui renvoie le numéro de la question ciblée.
*Recoit de la question.
*Renvoie le numéro de la question.
*/
function GetNumero_questionQuestion($id_question)
{
	global $bdd;
	$rep = $bdd -> query('SELECT numero_question FROM QUESTION WHERE id_question='.$id_question);
	$don = $rep->fetchObject();
	$rep2 = $don->numero_question;
	$rep->closeCursor();
	return $rep2;
}

/*
*Fonction qui renvoie le texte de la question ciblée.
*Recoit de l'id_question de la question.
*Renvoie le texte de la question.
*/
function GetTexteQuestion($id_question)
{
	global $bdd;
	$rep = $bdd -> query('SELECT texte FROM QUESTION WHERE id_question='.$id_question);
	$don = $rep->fetchObject();
	$rep2 = $don->texte;
	$rep->closeCursor();
	return $rep2;
}

/*
*Fonction qui renvoie si la question à déja une réponse.
*Recoit de l'id_utilisateur de l'utilisateur et l'id_question de la question.
*Renvoie 0 pour n'a pas été faite, 1 pour a été faite.
*/
function VerifierSiDejaReponse($id_utilisateur, $id_question)
{
	global $bdd;
	$rep=$bdd->query("SELECT COUNT(*) nb FROM REPONSE WHERE id_utilisateur =".$id_utilisateur." AND id_question=".$id_question);
	$question=$rep->fetchObject();
	$rep2 = $question->nb;
	$rep->closeCursor();
	return $rep2;
}

/*
*Fonction qui renvoie le texte de la réponse.
*Recoit l'id_utilisateur de l'utilisateur et l'id_question de la question.
*Renvoie le texte de la réponse.
*/
function GetTexteReponse($id_utilisateur, $id_question)
{
	global $bdd;
	$req=$bdd->query("SELECT * FROM REPONSE WHERE id_utilisateur =".$id_utilisateur." and id_question=" .$id_question);
	$texte=$req->fetchObject();
	$texte2=$texte->reponse;
	return $texte2;
	$req->closeCursor();
}

/*
*Fonction qui ajoute une réponse à la bdd.
*Recoit de l'id_utilisateur de l'utilisateur et l'id_question de la question et la réponse texte à associé.
*Ajoute une réponse dans la bdd.
*/
function AjouterReponse($id_utilisateur, $id_question, $texte_reponse)
{
	global $bdd;
	$req = $bdd->prepare('INSERT INTO REPONSE(id_utilisateur, id_question, reponse) 
		VALUES(:id_utilisateur, :id_question, :reponse)');
	$req->execute(array(
		'id_utilisateur' => $id_utilisateur,
		'id_question' => $id_question,
		'reponse' => $texte_reponse,
	));
	$req->closeCursor();
}

/*
*Fonction qui met à jour un réponse de la bdd.
*Recoit de l'id_utilisateur de l'utilisateur et l'id_question de la question et la réponse texte à associé.
*Modifie une réponse dans la bdd.
*/
function UpdateReponse($id_utilisateur, $id_question, $texte)
{
	global $bdd;
	echo 'Dans update' .$id_utilisateur .' ' .$id_question .' ' .$texte;
	$req = $bdd->prepare('UPDATE REPONSE SET reponse = :Q WHERE id_question = :id_question and id_utilisateur = :id_utilisateur');
	$req -> execute(array(
		'Q' => $texte,
		'id_question' => $id_question,
		'id_utilisateur' => $id_utilisateur
	));
}

/*
*Fonction qui renvoie tous les utilisateurs.
*Renvoie un tableau avec tous les utilisateurs.
*/
function GetTousLesUtilisateurs()
{
	global $bdd;
	$i = 0;
	$rep = $bdd -> query("SELECT login FROM UTILISATEUR");
	while ($don = $rep->fetch())
	{
		$login[$i] = $don['login'];
		$i++;
	}
	$rep->closeCursor();
	return $login;
}

/*
*Fonction qui renvoie le password de l'utilisateur.
*Renvoie le passord de l'utilisateur.
*/
function GetPasswordUtilisateur($login)
{
	global $bdd;
	$req = $bdd->prepare("SELECT * FROM UTILISATEUR WHERE login= ?");
	$req->execute(array($login)); //Erreur de merde car on peut pas faire login=".$login
	$don = $req->fetchObject();
	$req2 = $don->password;
	$req->closeCursor();
	return $req2;
}

/*
*Fonction qui renvoie le password de l'utilisateur.
*Renvoie le passord de l'utilisateur.
*/
function GetIdUtilisateur($login)
{
	global $bdd;
	$req=$bdd->prepare("SELECT id_utilisateur FROM UTILISATEUR WHERE login= ?");
	$req->execute(array($login));
	$id=$req->fetchObject();
	$id2=$id->id_utilisateur;
	$req->closeCursor();
	return $id2;
}

/*
*Fonction enregistre un utilisateur.
*Renvoie le login, le password et si l'utilisateur est prof.
*/
function AjouterUtilisateur($login, $password, $prof)
{
	global $bdd;
	$req = $bdd->prepare('INSERT INTO UTILISATEUR(login, password, prof,) 
		VALUES(:login, :password, :prof)');
	$req->execute(array(
		'login' => $login,
		'password' => $password,
		'prof' => $prof,
	));
	$req->closeCursor();
}
/*
*Fonction renvoie les numero des questions répondues par l'utilisateur.
*Recoit id_utilisateur de l'utilisateur.
*Renvoie un tableau de numero_question.
*/
function GetTousId_questionRepondues($id_utilisateur)
{
	global $bdd;
	$rep = $bdd->prepare('SELECT * FROM REPONSE WHERE id_utilisateur = ?');
	$rep->execute(array($id_utilisateur));
	$i = 0;
	while($don = $rep->fetch())
	{
		$info[$i] = $don['id_question'];
		$i++;
	}				
	$rep->closeCursor();
	return $info;
}

/*
*GetReponseReponseFonction renvoie la réponse d'une question.Fonction renvoie la réponse d'une question.
*Recoit l'id_utilisateur de l'utilisateur et id_question de la réponse.
*Renvoie la réponse de REPONSE.
*/
function GetReponseReponse($id_utilisateur, $id_question)
{
	global $bdd;
	$req = $bdd->prepare('SELECT reponse FROM REPONSE WHERE id_utilisateur = ? and id_question = ?');
	$req->execute(array($id_utilisateur, $id_question));
	$rep=$req->fetchObject();
	$rep2=$rep->reponse;
	$req->closeCursor();
	return $rep2;
}

/*
*Fonction renvoie la réponse d'une question.
*Recoit l'id_utilisateur de l'utilisateur et id_question de la réponse.
*Renvoie la réponse de REPONSE.
*/
function UpdateQuestion($id_question, $texte)
{
	global $bdd;
	$req = $bdd->prepare('UPDATE QUESTION SET texte = :Q WHERE id_question = :id_question');
	$req -> execute(array(
		'Q' => $texte,
		'id_question' => $id_question
	));
}

/*
*Fonction qui ajoute une question à la bdd.
*Recoit l'id_questionnaire de la question et la question texte à associé.
*Ajoute une question dans la bdd.
*/
function AjouterQuestion($id_questionnaire, $texte)
{
	global $bdd;
	$req = $bdd->prepare("INSERT INTO QUESTION(id_questionnaire, texte) 
						VALUES(:id_questionnaire, :texte)");
	$req->execute(array(
		'id_questionnaire' => $id_questionnaire,
		'texte' => $texte,
	));
}

/*
*Fonction qui retire une/des question précise à la bdd.
*Recoit l'id_questionnaire de la question et la question texte à associé.
*retire la/les question dans la bdd.
*/
function DeleteQuestion($id_question)
{
	global $bdd;
	$req = $bdd->exec("DELETE FROM QUESTION WHERE id_question=" .$id_question);
}
?>