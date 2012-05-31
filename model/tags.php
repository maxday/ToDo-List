<?php

include("../helper/utils.php");

/* tested */
function createTag($title, $user) {
	$sql = "INSERT INTO MYTODO_TAG(uuid, title, dateCreated, user) VALUES (?, ?, NOW(), ?)"; 
	$uniqid = (uniqid("",true));	
	$array = array($uniqid, $title, $user);

	launchQuery($sql, $array);
	return $uniqid;
}

/* tested */
/* PRIVATE */
function isTagBelongsToUser($uuid, $user) {
	$vConnect = connect();
	$res = 0;

	$sql = "SELECT uuid FROM MYTODO_TAG WHERE uuid=? AND user=?";
	$prepared_statement = $vConnect->prepare($sql);

	if ($prepared_statement->execute(array($uuid, $user)) == true) {
		$res = $prepared_statement->rowCount();
	}
	close($vConnect);
	return $res;
}

/* tested */
function deleteTag($uuid, $user) {
	if (isTagBelongsToUser($uuid, $user)) {
	  	$sql = "UPDATE MYTODO_TAG SET dateDeleted=NOW() WHERE uuid=?";
		$array = array($uuid);
		launchQuery($sql, $array);
	}
	else
		echo("Alerte");
}

/* tested */
function updateTagTitle($uuid, $user, $title) {
	if (isTagBelongsToUser($uuid, $user)) {
	  	$sql = "UPDATE MYTODO_TAG SET title=? WHERE uuid=?";
		$array = array($title, $uuid);
		launchQuery($sql, $array);
	}
	else
		echo("Alerte");
}

$res = seekTag("UTC", "4fb2ac296cb276.69528154");
print_r($res);

function seekTag($title, $user) {
	$vConnect = connect();
	$res = 0;

	$sql = "SELECT uuid FROM MYTODO_TAG WHERE title=? AND user=?";
	$prepared_statement = $vConnect->prepare($sql);

	if ($prepared_statement->execute(array($title, $user)) == true) {
		$res = $prepared_statement->fetchAll();
	}
	close($vConnect);
	return $res[0]['uuid'];
}
?>
