<?php
error_reporting(0);
if(empty($_SESSION)) {
	session_start();
}
require("../model/users.php");
$login = $_GET['user'];
$st = checkUserStatus($login);
$status = $st[0]; 
switch ($status) {
    case UNKNOWN_USER:
        $uuid = createUser($login);
		connectUser($uuid, $login);
		header("Location: ../view/");
		break;
    case USER_NOPASS:
		$uuid = $st[1];
        connectUser($uuid, $login);
		header("Location: ../view/");
		break;
    case USER_PASS:
			header("Location: ../view/?user=$login");
			break;
	default:
		echo "Error";
		break;
}
?>