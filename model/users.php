<?php

include("../helper/utils.php");

/* tested */
function createUser($login) {
	$sql = "INSERT INTO MYTODO_USER(uuid, login, dateCreated) VALUES (?, ?, NOW())";
	$uniqid = (uniqid("",true));
	$array = array($uniqid, $login);
	launchQuery($sql, $array);
	return $uniqid;
}
	
/* tested */
function securizeAccount($uuid, $pwd) {
	$sql = "UPDATE MYTODO_USER SET pwd=? WHERE uuid=?";
	$array = array($pwd, $uuid);

	launchQuery($sql, $array);
}

/* tested */
function deleteUser($uuid) {
	$vConnect = connect();
	
	$sql = "DELETE FROM MYTODO_TASK WHERE user=?";
	$prepared_statement = $vConnect->prepare($sql);
	$prepared_statement->execute(array($uuid));

	$sql = "DELETE FROM MYTODO_TAG WHERE user=?";
	$prepared_statement = $vConnect->prepare($sql);
	$prepared_statement->execute(array($uuid));
	
	$sql = "DELETE FROM MYTODO_USER WHERE uuid=?";
	$prepared_statement = $vConnect->prepare($sql);
	$prepared_statement->execute(array($uuid));
	
	close($vConnect);
}

/* tested */
function updateEmail($uuid, $email) {
	$sql = "UPDATE MYTODO_USER SET email=? WHERE uuid=?";
	$array = array($email, $uuid);
	
	launchQuery($sql, $array);
}

/* tested */
function enableTips($uuid) {
	return updateTips($uuid, 1);
}

/* tested */
function disableTips($uuid) {
	return updateTips($uuid, 0);
}

/* PRIVATE */
/* tested */
function updateTips($uuid, $enable) {
	$sql = "UPDATE MYTODO_USER SET hideTips=? WHERE uuid=?";
	$array = array($enable, $uuid);
	
	launchQuery($sql, $array);
}

/* tested */
function enableAdvancedUser($uuid) {
	return updateAdvanced($uuid, 1);
}

/* tested */
function disableAdvancedUser($uuid) {
	return updateAdvanced($uuid, 0);
}
	
/* PRIVATE */
/* tested */
function updateAdvanced($uuid, $isAdvanced) {
	$sql = "UPDATE MYTODO_USER SET isAdvancedUser=? WHERE uuid=?";
	$array = array($isAdvanced, $uuid);
	
	launchQuery($sql, $array);
}

/* tested */
function isProtected($uuid) {
	$sql = "SELECT isProtected FROM MYTODO_PROTECT WHERE uuid=?";
	$vConnect = connect();
	
	$prepared_statement = $vConnect->prepare($sql);
	$prepared_statement->execute(array($uuid));

	$line = $prepared_statement->fetch(PDO::FETCH_OBJ);
	close($vConnect);

	return $line->isProtected;
}

// à tester
function doesUserExist($login) {
	$sql = "SELECT uuid FROM MYTODO_USER WHERE login=?";
	$vConnect = connect();
	
	$prepared_statement = $vConnect->prepare($sql);
	$prepared_statement->execute(array($login));

	$line = $prepared_statement->fetch(PDO::FETCH_OBJ);
	close($vConnect);

	return $line->uuid;
}

// à tester
function checkUserStatus($login) {

	$uuid = doesUserExist($login); 
	
	if ($uuid != "") {
		if ( isProtected($uuid) ) {
			return array(USER_PASS, $uuid);
		} else {
			return array(USER_NOPASS, $uuid);
		}
	} 
	else {
		return array(UNKNOWN_USER);
	}
}

// plus ou moins tested, initialise la session utilisateur
function connectUser($uid, $login) { 
	$_SESSION['uuid'] = $uid;
	$_SESSION['login'] = $login;
	return RETURN_USER_CONNECTED; 
}

// Verifie si le password est correct
function checkPwd($uid, $pwd) {
	$sql = "SELECT login, pwd FROM MYTODO_USER WHERE uuid=?";
	$vConnect = connect();
	
	$prepared_statement = $vConnect->prepare($sql);
	$prepared_statement->execute(array($uid));

	$line = $prepared_statement->fetch(PDO::FETCH_OBJ);
	close($vConnect);

	if ($line->pwd == md5($pwd) ) {
		connectUser($uid, $line->login);
		return RETURN_USER_CONNECTED;
	}
	else {
		return UNCORRECT_PWD;
	}
}
 
?>
