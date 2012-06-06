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
	}
	
	// Tri sur l'importance
	if ( isset($importance) ) { 
		$array = sortTasksByImportance($importance, $_SESSION['uuid']); 
	}
	
	// Tri sur la priorite
	if ( isset($priority) ) { 
		$array = sortTasksByPriority($priority, $_SESSION['uuid']); 
	}	
	
	if ( isset($category) ) {
		$array = sortTasksByCategory($category, $_SESSION['uuid']);
	}
	
	formatTaskList($array);

?>