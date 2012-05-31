<?php

include_once('../helper/utils.php');

/* tested */
function createTask($title, $dueDate, $priority, $isImportant, $tag, $user) {
	if($dueDate=="")
		$dueDate = null;
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
function analyzeLineTask($line){		
	$subject = $line;
	$pattern = '/\A(.+)\s-/U';
	preg_match($pattern, $subject, $name);

	$pattern = '/\s-i\s/';
	preg_match($pattern, $subject, $i);
	if(isset($i[0]))
		$important = 1;
	else
		$important = 0;

	$pattern = '/\+p|\+\+p|-p|--p/';
	preg_match($pattern, $subject, $p);

	if(isset($p[0])){
		if($p[0] == "--p")
			$priority = 0;
		elseif($p[0] == "-p")
			$priority = 1;
		elseif($p[0] == "+p")
			$priority = 3;
		elseif($p[0] == "++p")
			$priority = 4;
	}
	else
		$priority = 2;

	$pattern = '/\s-d\s([0-9]{8}|[0-9]{2}-[0-9]{2}-[0-9]{4}|[0-9]{2}\/[0-9]{2}\/[0-9]{4})/';
	preg_match($pattern, $subject, $d);
	if(isset($d[0]))
		$date = $d[1];
	else
		$date = "";

	$pattern = '/\s-l\s([a-zA-Z]+)/';
	preg_match($pattern, $subject, $l);
	if(isset($l[0]))
		$tag = $l[1];
	else
		$tag = "";
	
	if(isset($name[1]))
		return array($name[1], $important, $priority, $date, $tag);
	else
		return array($line, 0, 2, "", "");
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

/* tested */
function seeTasks($uuid) {
	$vConnect = connect();
	$returnArray = array();
	$sql = "SELECT * FROM MYTODO_TASK WHERE user=?";
	$prepared_statement = $vConnect->prepare($sql);
	$tasks = array();
	if($prepared_statement->execute(array($uuid)) == true) {
		while ( $line = $prepared_statement->fetch(PDO::FETCH_OBJ) ) {
	    	array_push($returnArray, $line);
	  	}
	}	
	return $returnArray;
}
?>
