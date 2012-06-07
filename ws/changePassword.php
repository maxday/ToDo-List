<?php 
	if(empty($_SESSION)) {
		session_start();
	}

	require_once("../model/users.php");

	if ( isset($_POST["old"]) && isset($_POST["pass"])) {
		$pass = $_POST["pass"];
		$old = $_POST["old"];
		$user = $_SESSION['uuid'];

		if(isPasswordCorrect($user, $old)){
			changePassword($user, $pass);
			echo 1;
		}
		else
			echo 2;
	}
?>