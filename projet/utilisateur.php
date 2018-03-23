<?php



class Utilisateur
{
   
	private $login = 'indéfini';
	private $prof = 0;
	private $id = 0;
	      
	//Getters
	public function getLogin()
	{
		return $this->login;  
	}
	public function getProf()
	{
		return $this->prof;  
	}
	public function getId()
	{
		return $this->id;  
	}
	     
	//Setters 
	public function setLogin($login2)
	{
		$this->login = $login2;
	}
	public function setProf($prof2)
	{
		$this->prof = $prof2;
	}
	public function setId($id2)
	{
		$this->id = $id2;
	}
	      
	//Constructeurs
	public function __construct($id)
	{
		global $bdd;
		$info = $bdd->prepare('SELECT * FROM UTILISATEUR WHERE id_utilisateur = ?');
		$info -> execute(array($id));
		$info = $info->fetch();
		$this->login = $info['login'];
		$this->prof = $info['prof'];
		$this->id = $info['id_utilisateur'];
	} 
}

?>