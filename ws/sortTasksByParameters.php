<?php
	if(empty($_SESSION)) {
		session_start();
	}		
	require("../model/tags.php");
	require("../model/tasks.php");
	extract($_POST);
	
	if ( isset($date) ) { 
		$array = sortTasksByDate($date, $_SESSION['uuid']);
		formatTaskList($array);
	}

?>