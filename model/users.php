<?php

include_once("../helper/utils.php");

/* tested */
function createUser($login) {
	$sql = "INSERT INTO MYTODO_USER(uuid, login, dateCreated) VALUES (?, ?, NOW())";
	$uniqid = (uniqid("",true));
	$array = array($uniqid, $login);
	launchQuery($sql, $array);
	createDefaultTagForUser($uniqid);
	addProtectRow($uniqid, 0);
	return $uniqid;
}
	
/* tested */
function securizeAccount($uuid, $pwd) {
	$sql = "UPDATE MYTODO_USER SET pwd=? WHERE uuid=?";
	$array = array(md5($pwd), $uuid);

	launchQuery($sql, $array);
	protectionOfARow($uuid, 1);
}

function changePassword($uuid, $pwd) {
	$sql = "UPDATE MYTODO_USER SET pwd=? WHERE uuid=?";
	$array = array(md5($pwd), $uuid);

	launchQuery($sql, $array);
}

function addProtectRow($uuid, $value) {
	$sql = "INSERT INTO MYTODO_PROTECT(uuid, isProtected) VALUES (?, ?)";
	$array = array($uuid, $value);
	launchQuery($sql, $array);
}

function unSecurizeAccount($uuid) {
	$sql = "UPDATE MYTODO_USER SET pwd=null WHERE uuid=?";
	$array = array($uuid);

	launchQuery($sql, $array);
	protectionOfARow($uuid, 0);
}

function protectionOfARow($uuid, $value) {
	$sql = "UPDATE MYTODO_PROTECT SET isProtected=? WHERE uuid=?";
	$array = array($value, $uuid);

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

function isPasswordCorrect($uid, $pwd) {
	$sql = "SELECT login, pwd FROM MYTODO_USER WHERE uuid=?";
	$vConnect = connect();
	
	$prepared_statement = $vConnect->prepare($sql);
	$prepared_statement->execute(array($uid));

	$line = $prepared_statement->fetch(PDO::FETCH_OBJ);
	close($vConnect);

	if ($line->pwd == md5($pwd) )
		return 1;
	else
		return 0;
}

// plus ou moins tested, initialise la session utilisateur
function connectUser($uid, $login) { 
	$_SESSION['uuid'] = $uid;
	$_SESSION['login'] = $login;
	return RETURN_USER_CONNECTED; 
}

// Verifie si le password est correct et lance la session
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

// devrait normalement faire appel à une méthode située dans le model tag,  ou au moins utiliser le créer tag de tags.php, mais
// lorsque je veux faire un include_once("tags.php") dans ce fichier,  tout plante et je ne sais aps pourquoi. surement 
// problème de double inclusion ou je sais pas trop
// dégueulasse, mais ca marche
function createDefaultTagForUser($user_uuid) {
	
	$sql = "INSERT INTO MYTODO_TAG(uuid, title, dateCreated, user) VALUES (?, ?, NOW(), ?)"; 
	$uniqid = (uniqid("",true));	
	$array = array($uniqid, "Travail", $user_uuid);

	launchQuery($sql, $array);
	
	$sql = "INSERT INTO MYTODO_TAG(uuid, title, dateCreated, user) VALUES (?, ?, NOW(), ?)"; 
	$uniqid = (uniqid("",true));	
	$array = array($uniqid, "Courses", $user_uuid);

	launchQuery($sql, $array);
	
}

/* tested */
function isDisplayFilters($uuid) {
	$sql = "SELECT displayFilters FROM MYTODO_USER WHERE uuid=?";
	$vConnect = connect();
	$prepared_statement = $vConnect->prepare($sql);
	$prepared_statement->execute(array($uuid));
	$line = $prepared_statement->fetch(PDO::FETCH_OBJ);
	close($vConnect);
	return $line->displayFilters;
}

/* tested */
function isDisplayCalendar($uuid) {
	$sql = "SELECT displayCalendar FROM MYTODO_USER WHERE uuid=?";
	$vConnect = connect();
	$prepared_statement = $vConnect->prepare($sql);
	$prepared_statement->execute(array($uuid));
	$line = $prepared_statement->fetch(PDO::FETCH_OBJ);
	close($vConnect);
	return $line->displayCalendar;
}

/* tested */
function displayCalendar($uuid) {
	return updateCalendar($uuid, 1);
}

/* tested */
function hideCalendar($uuid) {
	return updateCalendar($uuid, 0);
}

/* tested */	
function displayFilters($uuid) {
	return updateFilters($uuid, 1);
}

/* tested */
function hideFilters($uuid) {
	return updateFilters($uuid, 0);
}

/* PRIVATE */
/* tested */
function updateCalendar($uuid, $isDisplayed) {
	$sql = "UPDATE MYTODO_USER SET displayCalendar=? WHERE uuid=?";
	$array = array($isDisplayed, $uuid);
	launchQuery($sql, $array);
}

/* PRIVATE */
/* tested */
function updateFilters($uuid, $isDisplayed) {
	$sql = "UPDATE MYTODO_USER SET displayFilters=? WHERE uuid=?";
	$array = array($isDisplayed, $uuid);
	launchQuery($sql, $array);
}


?>
