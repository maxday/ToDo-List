<?php
	session_start();
	require("../model/users.php");
	echo updateFilters($_SESSION['uuid'], $_POST['show']);
?>