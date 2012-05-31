<?php 

	if(empty($_SESSION)) {
		session_start();
	}

	require("../model/tags.php");
	if ( isset($_POST["tag"])) {
		$tag = $_POST["tag"];
		echo createTag($tag,$_SESSION["uuid"]);
	}
	
?>