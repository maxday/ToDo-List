<?php
	session_start();
	require("../model/users.php");
	echo updateCalendar($_SESSION['uuid'], $_POST['show']);
?>