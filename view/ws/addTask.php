<?php
	if(empty($_SESSION)) {
		session_start();
	}
	
	require("../../model/tasks.php");
	
	extract($_POST);
	if ( isset($_SESSION['uuid'])) {
		// Clé étrangère peut être nulle \o/
		createTask($title_task, "", "", "", null, $_SESSION['uuid']);
		echo "1";
	}
	else {
		echo "-1";
	}

?>