<?php

	if(empty($_SESSION)) {
		session_start();
	}
		
	require("../model/tags.php");
	require("../model/tasks.php");

	extract($_POST);	
	$array = analyzeLineTask($_POST['complexeTask']);

	if($array[4] == "")
		$uuidTag = null;
	else {
		$uuidTag = seekTag($array[4], $_SESSION['uuid']);
		if($uuidTag == 0) {
			if(hasNotReachedMaxTag($_SESSION['uuid'])) {
				$uuidTag = createTag($array[4], $_SESSION['uuid']);
			}
			else {
				$uuidTag = null;
			}
		} 
	}
	
	createTask($array[0], $array[3], $array[2], $array[1], $uuidTag, $_SESSION['uuid']);
	print_r(seeTasks($_SESSION['uuid']));
?>
