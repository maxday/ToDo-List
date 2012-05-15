<?php
	$login = $_POST["login"];
	$test_existe = true;
	
	// s'il existe
	if ($test_existe) {
		// et qu'il n'a pas de pass
		if ($login == "a") {
			echo "1";
		}
		// il a un pass 
		else {
			echo "2";
		}
	// sinon
	} else {
		echo "3";
	}
	
	// s'il n'existe pas
?>