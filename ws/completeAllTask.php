<?php 

	if(empty($_SESSION)) {
		session_start();
	}

	require("../model/tasks.php");
	if (isset($_SESSION["uuid"])) {
		echo completeAllTask($_SESSION["uuid"]);
	}
	
?>