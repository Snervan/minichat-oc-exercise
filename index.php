<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Minichat</title>
	<link rel="stylesheet" href="styles.css" />
</head>

<body>
	<?php include('class/bddClass.php') ?>

	<form action="minichat_post.php" method="post">

		<label for="pseudo">Pseudo : </label>
		<input type="text" id="pseudo" name="pseudo" 
				<?php if (isset($_COOKIE['pseudo'])) {
									echo "value='".htmlspecialchars($_COOKIE['pseudo'])."' ";
								}?> 
				required /> <BR>

		<label for="msg">Message : </label>
		<input type="text" id="msg" name="message" required /> <BR>

		<button type="submit">Envoyer Message</button>
	</form>

	<?php 
		$bdd = new BDD();

		if(isset($_GET['page']) && is_numeric($_GET['page']))
		{
			$page = (int)htmlspecialchars($_GET['page']);
			$bdd->GetMessages($page, 10);
		} else {
			$bdd->GetMessages(1, 10);
		}
	 ?>

</body>
</html>