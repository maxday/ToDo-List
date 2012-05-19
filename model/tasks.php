<?php

include("../helper/utils.php");

/* tested */
function createTask($title, $dueDate, $priority, $isImportant, $tag, $user) {
	$sql = "INSERT INTO MYTODO_TASK(uuid, dateCreated, title, dueDate, priority, isImportant, tag, user) VALUES (?, NOW(), ?, ?, ?, ?, ?, ?)"; 
	$uniqId = uniqid("",true);
	$array = array($uniqId, $title, $dueDate, $priority, $isImportant, $tag, $user);
	
	launchQuery($sql, $array);
	return $uniqId;
}

/* tested */
/* PRIVATE */
function isTaskBelongsToUser($uuid, $user) {
	$vConnect = connect();
	$sql = "SELECT uuid FROM MYTODO_TASK WHERE uuid=? AND user=?";
	$prepared_statement = $vConnect->prepare($sql);
	
	if($prepared_statement->execute(array($uuid, $user)) == true) {
		return $prepared_statement->rowCount();
	}
}
/* tested */
function deleteTask($uuid, $user) {
	if (isTaskBelongsToUser($uuid, $user)) {
	  	$sql = "UPDATE MYTODO_TASK SET dateDeleted=NOW() WHERE uuid=?";
		$array = array($uuid);
		launchQuery($sql, $array);
	}
	else
		echo("Alerte");
}

/* tested */
function completeTask($uuid, $user) {
	if (isTaskBelongsToUser($uuid, $user)) {
	  	$sql = "UPDATE MYTODO_TASK SET dateCompleted=NOW() WHERE uuid=?";
		$array = array($uuid);
		launchQuery($sql, $array);
	}
	else
		echo("Alerte");
}

/*tested*/
function updateTaskTitle($uuid, $user, $title) {
	if (isTaskBelongsToUser($uuid, $user)) {
	  	$sql = "UPDATE MYTODO_TASK SET title=? WHERE uuid=?";
		$array = array($title, $uuid);
		launchQuery($sql, $array);
	}
	else
		echo("Alerte");
}

/*tested*/
function updateTaskDueDate($uuid, $user, $dueDate) {
	if (isTaskBelongsToUser($uuid, $user)) {
	  	$sql = "UPDATE MYTODO_TASK SET dueDate=? WHERE uuid=?";
		$array = array($dueDate, $uuid);
		launchQuery($sql, $array);
	}
	else
		echo("Alerte");
}

/*tested*/
function updateTaskPriority($uuid, $user, $priority) {
	if (isTaskBelongsToUser($uuid, $user)) {
	  	$sql = "UPDATE MYTODO_TASK SET priority=? WHERE uuid=?";
		$array = array($priority, $uuid);
		launchQuery($sql, $array);
	}
	else
		echo("Alerte");
}

/*tested*/
function updateTaskImportant($uuid, $user, $isImportant) {
	if (isTaskBelongsToUser($uuid, $user)) {
	  	$sql = "UPDATE MYTODO_TASK SET isImportant=? WHERE uuid=?";
		$array = array($isImportant, $uuid);
		launchQuery($sql, $array);
	}
	else
		echo("Alerte");
}
?>
