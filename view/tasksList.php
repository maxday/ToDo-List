<?php
	require('../model/tasks.php');
	
	print_r(seeTasks($_SESSION['login']));

?>