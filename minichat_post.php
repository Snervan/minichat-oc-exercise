<?php
include('class/bddClass.php');


if(isset($_POST['pseudo']) && isset($_POST['message'])) {
	$bdd = new BDD();
	$bdd->saveMessage(htmlspecialchars($_POST['pseudo']), htmlspecialchars($_POST['message']));
	setcookie('pseudo', htmlspecialchars($_POST['pseudo']), time()+24*3600, null, null, false, true);
}

header('Location: index.php');

?>