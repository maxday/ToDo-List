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
	
/*
function deleteUser($uuid) {
	$vConnect = connect();
	try {
		$sql = "DELETE MYTODO_PROTECT WHERE uuid=?";
		$prepared_statement = $vConnect->prepare($sql);
		$prepared_statement->execute(array($uuid));	
			
	} catch(Exception $e) {
		
		echo 'Erreur : '.$e->getMessage().'<br />';
		echo 'N° : '.$e->getCode();
	}

	
	$sql = "DELETE MYTODO_TAG WHERE user=?";
	$prepared_statement = $vConnect->prepare($sql);
	$prepared_statement->execute(array($uuid));
	
	$sql = "DELETE MYTODO_TASK WHERE user=?";
	$prepared_statement = $vConnect->prepare($sql);
	$prepared_statement->execute(array($uuid));
	
	$sql = "DELETE MYTODO_USER WHERE uuid=?";
	$prepared_statement = $vConnect->prepare($sql);
	$prepared_statement->execute(array($uuid));
	
	close($vConnect);
}
*/	

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
function updateAdvanced($uuid, $isAdvanced) {
	$sql = "UPDATE MYTODO_USER SET isAdvancedUser=? WHERE uuid=?";
	$array = array($isAdvanced, $uuid);
	
	launchQuery($sql, $array);
}

function isProtected($uuid) {
	$sql = "SELECT isProtected FROM MYTODO_PROTECT WHERE uuid=?";
	$vConnect = new Connect();
	$vConnect->mConnect();
	
	$prepared_statement = $vConnect->prepare($sql);
	$prepared_statement->execute($uuid);

	$line = $prepared_statement->fetch(PDO::FETCH_OBJ);
	$vConnect->mClose();
	return $line->identifiant;
}


?>
