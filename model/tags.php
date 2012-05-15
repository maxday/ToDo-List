<?php
function createTag($title, $user) {
	$sql = "INSERT INTO MYTODO_TASK(title, dateCreated, user) VALUES (?, NOW(), ?)"; 
	$array = array($title, $user));

	launchQuery($sql, $array);
}

function verifyTag($uuid, $user) {
	$vConnect = new Connect();
	$vConnect->mConnect();

	$sql = "SELECT title FROM MYTODO_TAG WHERE uiid=? AND user=?";
	$prepared_statement = $vConnect->prepare($sql);

	if ($res = $prepared_statement->execute($uuid, $user);){
	   if ($res->fetchColumn() > 0)
		  	return true;
		else
			return false;
	}
}

function deleteTag($uuid, $user) {
	if (verifyTag($uuid, $user)) {
	  	$sql = "UPDATE MYTODO_TAG SET dateDeleted=NOW() WHERE uuid=?";
		$array = array($uuid);
		launchQuery($sql, $array);
	}
	else
		echo("Alerte");
}

function updateTagTitle($uuid, $user, $title) {
	if (verifyTask($uuid, $user)) {
	  	$sql = "UPDATE MYTODO_TAG SET title=? WHERE uuid=?";
		$array = array($title, $uuid);
		launchQuery($sql, $array);
	}
	else
		echo("Alerte");
}

?>
