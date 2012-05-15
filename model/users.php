<?php
function createUser($login) {
	$sql = "INSERT INTO MYTODO_USER(login, dateCreated) VALUES (?, NOW())";
	$array = array($login);
	
	launchQuery($sql, $array);
}
	
function securizeAccount($uiid) {
	$sql = "UPDATE MYTODO_USER SET pwd=? WHERE uuid=?";
	$array = array($pwd, $uiid);

	launchQuery($sql, $array);
}
	
function deleteUser($uuid) {
	$vConnect = new Connect;
	$vConnect->mConnect();
	
	$sql = "DELETE MYTODO_TAG WHERE user=?";
	$prepared_statement = $vConnect->prepare($sql);
	$prepared_statement->execute(array($uuid);
	
	$sql = "DELETE MYTODO_TASK WHERE user=?";
	$prepared_statement = $vConnect->prepare($sql);
	$prepared_statement->execute(array($uuid);
	
	$sql = "DELETE MYTODO_USER WHERE uuid=?";
	$requete_preparee = $vConnect->prepare($sql);
	$requete_prepare->execute(array($uuid);
	
	$vConnect->mClose();
}
	
function updateEmail($email) {
	$sql = "UPDATE MYTODO_USER SET email=? WHERE uuid=?";
	$array = array($email, $uiid);
	
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
	$vConnect = new Connect;
	$vConnect->mConnect();
	
	$prepared_statement = $vConnect->prepare($sql);
	$prepared_statement->execute($uuid);

	$line = $prepared_statement->fetch(PDO::FETCH_OBJ);
	$vConnect->mClose();
	return $line->identifiant;
}
?>
