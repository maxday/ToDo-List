<?php
	if(empty($_SESSION)) {
		session_start();
	}
	
	require("../model/users.php");
	
	extract($_POST);
	
	if ( isset($_SESSION['uuid'])) {
		echo securizeAccount($_SESSION['uuid'], $pass);
	}
	else {
		echo "-1";
	}

?>