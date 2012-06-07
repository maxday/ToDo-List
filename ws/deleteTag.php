<?php

	if(empty($_SESSION)) {
		session_start();
	}

	require("../model/tags.php");
	
	$data = $_POST['tag'];

	echo deleteTag($data, $_SESSION['uuid']);
	
?>