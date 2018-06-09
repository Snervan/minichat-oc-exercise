<?php
/**
* MySQL Database Class for Minichat
*/
class BDD
{
	private $bdd ;
	
	function __construct()
	{
		try 
		{
			/* Fichier PHP contenant les infos sur l'adresse du serveur, 
			le nom de la BDD et les infos utilisateurs */
			include('conf/conf.php');

			$connectRequest = "mysql:host=".$hostAddress.";dbname=".$databaseName.";charset=utf8;";

			$this->bdd = new PDO($connectRequest, $user, $password);
		} 
		catch(Exception $e) {
			echo "Erreur :".$e;
		}
	}

	function getMessages($page, $nbMessagesParPages = 5) {
		include('conf/conf.php');

		$offset = ($page-1) * $nbMessagesParPages; //On y affecte l'index de départ

		$reqText = "SELECT pseudo, message, DATE_FORMAT(datemsg, '%d/%m/%Y %H:%i:%ss') AS datemsg FROM ". $tableName ." ORDER BY id DESC LIMIT ". $offset .", ". $nbMessagesParPages ." ;";

		$result = $this->bdd->query($reqText);

		while ($data = $result->fetch()) {
				echo "<p>[". htmlspecialchars($data['datemsg']) ."] <strong>". htmlspecialchars($data['pseudo']) ."</strong> : ". htmlspecialchars($data['message']) ."</p>";
		}

		$result->closeCursor();

		$this->pagination($offset, $page, $nbMessagesParPages, $tableName);
	}

	function pagination($offset, $page, $nbMessagesParPages, $tableName) {
		$request = $this->bdd->query("SELECT COUNT(id) FROM $tableName");

		while($donnees = $request->fetch())
		{
			$nbrelignes = $donnees[0]; //Recoit le nombre total de lignes de la table
		}

		$offset = ($page-1) * $nbMessagesParPages;

		//On calcul le nombre de pages qu'il y aura
		$nbrepages = $nbrelignes / $nbMessagesParPages;

		$request->closeCursor();

		for ($i=0; $i < $nbrepages; $i++) { 
			echo "<a href='index.php?page=".($i+1)."'> ".($i+1)."</a>    ";
		}
	}

	function saveMessage($pseudo, $message) {
		include('conf/conf.php');
		$reqText = "INSERT INTO ".htmlspecialchars($tableName)."(pseudo, message, datemsg) VALUES(? , ?, NOW())";

		$request = $this->bdd->prepare($reqText);
		$request->execute(array($pseudo, $message));
	}
}

?>