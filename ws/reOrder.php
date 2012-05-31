<?php

	require("../model/tasks.php");
	
	$data = $_POST['order'];
	echo reOrderTask(preg_split("!,!", $data));
	
?>