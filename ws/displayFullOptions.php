<?php
	session_start();
	require("../model/users.php");
	echo updateFullOptions($_SESSION['uuid'], $_POST['show']);
?>