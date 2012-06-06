<?php
	if (isset($_SESSION)) {
		session_destroy();
		header('location: index.php');
	}
	else {
		// Un mec qui s'est amusé a taper mytodo.fr/logout.php > On l'envoie vers l'accueil ?
		header('location: index.php');
	}
?>