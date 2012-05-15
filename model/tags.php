<?php
function createTag($title, $user) {
	$sql = "INSERT INTO MYTODO_TASK(title, dateCreated, user) VALUES (?, NOW(), ?)"; 
	$array = array($title, $user));

	launchQuery($sql, $array);
}

function deleteTag($uuid, $user) {
	$vConnect = new Connect;
	$vConnect->mConnect();

	$sql = "SELECT title FROM MYTODO_TAG WHERE uiid=? AND user=?";
	$prepared_statement = $vConnect->prepare($sql);

	if ($res = $prepared_statement->execute($uuid, $user);) {
	   if ($res->fetchColumn() > 0) {
		  	$sql = "DELETE MYTODO_TAG WHERE uuid=?";
			$prepared_statement = $vConnect->prepare($sql);
			$prepared_statement->execute(array($uuid);
	   }
		else {
			echo("Alerte");
		}
	}
}
?>
