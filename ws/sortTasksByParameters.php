<?php
	if(empty($_SESSION)) {
		session_start();
	}	
	require("../model/tasks.php");
	extract($_POST);
	
	if ( isset($date) ) {
		echo sortTasksByDate($date, $_SESSION['uuid']);
	}

?>