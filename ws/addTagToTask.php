<?php

	require("../model/tasks.php");
	
	$uuidTag = $_POST['tag'];
	$uuidTask = $_POST['task'];
	
	
	
	echo updateTaskWithTag($uuidTask, $uuidTag);

	
?>