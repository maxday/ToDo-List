<?php
	session_start();
	include("../../model/tasks.php");
	
	extract($_POST);
	if ( isset($_SESSION['uuid'])) {
		createTask($title_task, "", "", "", "", $_SESSION['uuid']);
		echo "1";
	}
	else {
		echo "-1";
	}

?>