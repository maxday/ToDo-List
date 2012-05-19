<?php

include("../helper/utils.php");

function createTag($title, $user) {
	$sql = "INSERT INTO MYTODO_TAG(uuid, title, dateCreated, user) VALUES (?, ?, NOW(), ?)"; 
	$uniqid = (uniqid("",true));	
	$array = array($uniqid, $title, $user);

	launchQuery($sql, $array);
	return $uniqid;
}

/* PRIVATE */
function isTagBelongsToUser($uuid, $user) {
	$vConnect = connect();

	$sql = "SELECT uuid FROM MYTODO_TAG WHERE uuid=? AND user=?";
	$prepared_statement = $vConnect->prepare($sql);

	if ($prepared_statement->execute(array($uuid, $user)) == true) {
		return $prepared_statement->rowCount();
	}
	close($vConnect);
}

function deleteTag($uuid, $user) {
	if (isTagBelongsToUser($uuid, $user)) {
	  	$sql = "UPDATE MYTODO_TAG SET dateDeleted=NOW() WHERE uuid=?";
		$array = array($uuid);
		launchQuery($sql, $array);
	}
	else
		echo("Alerte");
}

function updateTagTitle($uuid, $user, $title) {
	if (isTagBelongsToUser($uuid, $user)) {
	  	$sql = "UPDATE MYTODO_TAG SET title=? WHERE uuid=?";
		$array = array($title, $uuid);
		launchQuery($sql, $array);
	}
	else
		echo("Alerte");
}
?>
