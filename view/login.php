<?php

	include("../../model/users.php");

	$login = $_POST["login"];
	$pass = $_POST["pass"];
	
	switch (checkUserStatus($login)) {
	    case UNKNOWN_USER:
	        createUser($login);
					return connectUser($login, null);
	        break;
	    case USER_NOPASS:
	        return connectUser($login, null);
	        break;
	    case USER_PASS:
					if (isset($pass)) {
						return connectUser($login,$pass);
					} else {
						return DISPLAY_PASS_FIELD;
					}
	        break;
			default:
					echo "ALLLLO";
	}
	
?>