<?php
function createTask($title, $dueDate, $priority, $isImportant, $tag, $user) {
	$sql = "INSERT INTO MYTODO_TASK(dateCreated, title, dueDate, priority, isImportant, tag, user) VALUES (NOW(), ?, ?, ?, ?, ?, ?)"; 
	$array = array($title, $dueDate, $priority, $isImportant, $tag, $user));
	
	launchQuery($sql, $array);
}

function verifyTask($uuid, $user) {
	$vConnect = new Connect();
	$vConnect->mConnect();

	$sql = "SELECT title FROM MYTODO_TASK WHERE uiid=? AND user=?";
	$prepared_statement = $vConnect->prepare($sql);

	if ($res = $prepared_statement->execute($uuid, $user);){
	   if ($res->fetchColumn() > 0)
		  	return true;
		else
			return false;
	}
}

function deleteTask($uuid, $user) {
	if (verifyTask($uuid, $user)) {
	  	$sql = "UPDATE MYTODO_TASK SET dateDeleted=NOW() WHERE uuid=?";
		$array = array($uuid);
		launchQuery($sql, $array);
	}
	else
		echo("Alerte");
}

function completeTask($uuid, $user) {
	if (verifyTask($uuid, $user)) {
	  	$sql = "UPDATE MYTODO_TASK SET dateCompleted=NOW() WHERE uuid=?";
		$array = array($uuid);
		launchQuery($sql, $array);
	}
	else
		echo("Alerte");
}

function updateTaskTitle($uuid, $user, $title) {
	if (verifyTask($uuid, $user)) {
	  	$sql = "UPDATE MYTODO_TASK SET title=? WHERE uuid=?";
		$array = array($title, $uuid);
		launchQuery($sql, $array);
	}
	else
		echo("Alerte");
}

function updateTaskDueDate($uuid, $user, $dueDate) {
	if (verifyTask($uuid, $user)) {
	  	$sql = "UPDATE MYTODO_TASK SET dueDate=? WHERE uuid=?";
		$array = array($dueDate, $uuid);
		launchQuery($sql, $array);
	}
	else
		echo("Alerte");
}

function updateTaskPriority($uuid, $user, $priority) {
	if (verifyTask($uuid, $user)) {
	  	$sql = "UPDATE MYTODO_TASK SET priority=? WHERE uuid=?";
		$array = array($title, $uuid);
		launchQuery($sql, $array);
	}
	else
		echo("Alerte");
}

function updateTaskImportant($uuid, $user, $isImportant) {
	if (verifyTask($uuid, $user)) {
	  	$sql = "UPDATE MYTODO_TASK SET isImportant=? WHERE uuid=?";
		$array = array($isImportant, $uuid);
		launchQuery($sql, $array);
	}
	else
		echo("Alerte");
}
?>
