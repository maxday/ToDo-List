<?php 
	if(empty($_SESSION)) {
		session_start();
	}
	require("../model/users.php");
	if ( isset($_POST["login"])) {
		$login = $_POST["login"];
		$st = checkUserStatus($login);
		$status = $st[0]; 
		switch ($status) {
		    case UNKNOWN_USER:
		        $uuid = createUser($login);
				echo connectUser($uuid, $login);
				break;
		    case USER_NOPASS:
				$uuid = $st[1];
		        echo connectUser($uuid, $login);
				break;
		    case USER_PASS:
				$uuid = $st[1];
				if (isset($_POST["pass"])) {
					$pass  = $_POST["pass"];
					echo checkPwd($uuid,$pass);
					break;
				} else {
					echo DISPLAY_PASS_FIELD;
					break;
				}
			default:
				echo "Error";
				break;
		}
	}
	
?>