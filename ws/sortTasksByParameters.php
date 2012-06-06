<?php
	if(empty($_SESSION)) {
		session_start();
	}		
	require("../model/tags.php");
	require("../model/tasks.php");
	extract($_POST);
	
	// Tri sur la date uniquement
	if ( isset($date) ) { 
		$array = sortTasksByDate($date, $_SESSION['uuid']);
		formatTaskList($array);
	}
	
	// Tri sur l'importance
	if ( isset($importance) ) { 
		$array = sortTasksByImportance($importance, $_SESSION['uuid']);
		formatTaskList($array);
	}

?>