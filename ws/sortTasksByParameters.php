<?php
	if(empty($_SESSION)) {
		session_start();
	}		
	require("../model/tags.php");
	require("../model/tasks.php"); 
	extract($_POST); 
	 
	if ( !isset($date) ) { $date = "undefined"; }
	if ( !isset($importance) ) { $importance = "undefined"; }
	if ( !isset($priority) ) { $priority = "undefined"; }
	if ( !isset($category) ) { 
		$cat = "undefined"; 
	}
	else {   
		if ( $category == "") {
			$cat = "undefined";
		}
		else {
			$category = preg_split('!&&!', $category); 
			if ( isset($category[1]) ) {
				$cat = $category; 
			}
			else {
				$cat = "undefined";
			}	
		}
	} 
	// Lancement de la requete
	$array = sortTasksByMultiCrits($date, $importance, $priority, $cat, $_SESSION['uuid']);

	
	formatTaskList($array);

?>