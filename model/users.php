<?php

include("../helper/utils.php");

function createUser($login) {
	$sql = "INSERT INTO MYTODO_USER(uuid, login, dateCreated) VALUES (?, ?, NOW())";
	$uniqid = (uniqid("",true));
	$array = array($uniqid, $login);
	launchQuery($sql, $array);
	return $uniqid;
}
	
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
	
function updateEmail($uuid, $email) {
	$sql = "UPDATE MYTODO_USER SET email=? WHERE uuid=?";
	$array = array($email, $uuid);
	
	launchQuery($sql, $array);
}
	
function updateTips($uuid) {
	$sql = "UPDATE MYTODO_USER SET hideTips=1 WHERE uuid=?";
	$array = array($uiid);
	
	launchQuery($sql, $array);
}
	
function updateAdvanced($uuid) {
	$sql = "UPDATE MYTODO_USER SET isAdvancedUser=1 WHERE uuid=?";
	$array = array($uiid);
	
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


/*$uniqid = createUser("testDelete");
securizeAccount($uniqid, "proute");
securizeAccount($uniqid, "");*/

updateEmail("4fb2ac817c62b3.98435945","coucou@foiof.com");

?>
