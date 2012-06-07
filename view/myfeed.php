<?php

	if(empty($_SESSION)) {
		session_start();
	}

	include_once("../helper/utils.php");

	function sortTasksByCategory($uuid) {
		$vConnect = connect();
		$returnArray = array(); 
		$sql = "SELECT * FROM MYTODO_TASK WHERE user = ? AND dueDate NOT LIKE '0000-00-00%'"; 
		$prepared_statement = $vConnect->prepare($sql);  
		if($prepared_statement->execute(array($uuid)) == true) { 
			while ( $line = $prepared_statement->fetch(PDO::FETCH_OBJ) ) {
				array_push($returnArray, $line); 
			}
		} 
		close($vConnect);
		return $returnArray;
	}
	
	$arrayFromSQL = sortTasksByCategory($_SESSION['uuid']);
	$arrayToJSON = array(); 
	
	for ($j = 0 ; $j < count($arrayFromSQL) ; $j++) {
		     $a = array('title' => $arrayFromSQL[$j] -> title, 'start' => $arrayFromSQL[$j] -> dueDate);
		     array_push($arrayToJSON, $a);
	} 
	
	echo json_encode($arrayToJSON);
?>