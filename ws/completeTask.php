<?php 

	if(empty($_SESSION)) {
		session_start();
	}

	require("../model/tasks.php");
	if ( isset($_POST["task"]) && isset($_SESSION["uuid"])) {
		echo completeTask($_POST["task"], $_SESSION["uuid"]);
	}
	
?>