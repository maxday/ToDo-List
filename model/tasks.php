<?php
function createTask($title, $dueDate, $priority, $isImportant, $tag, $user) {
	$sql = "INSERT INTO MYTODO_TASK(dateCreated, title, dueDate, priority, isImportant, tag, user) VALUES (NOW(), ?, ?, ?, ?, ?, ?)"; 
	$array = array($title, $dueDate, $priority, $isImportant, $tag, $user));
	
	launchQuery($sql, $array);
}

function verifyTask($uuid, $user) {
	$vConnect = new Connect;
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
		$vConnect = new Connect;
		$vConnect->mConnect();

	  	$sql = "DELETE MYTODO_TASK WHERE uuid=?";
		$prepared_statement = $vConnect->prepare($sql);
		$prepared_statement->execute(array($uuid);
	}
	else
		echo("Alerte");
}

function updateTask($uuid, $user) {
	if (verifyTask($uuid, $user)) {
		$vConnect = new Connect;
		$vConnect->mConnect();

	  	$sql = "UPDATE MYTODO_TASK SET WHERE uuid=?";
		$prepared_statement = $vConnect->prepare($sql);
		$prepared_statement->execute(array($uuid);
	}
	else
		echo("Alerte");
}

  `uuid` char(23) NOT NULL,
  `dateCreated` date NOT NULL,
  `dateCompleted` date DEFAULT NULL,
  `dateDeleted` date DEFAULT NULL,
  `title` varchar(30) NOT NULL,
  `dueDate` date DEFAULT NULL,
  `priority` char(2) DEFAULT NULL,
  `isImportant` tinyint(1) DEFAULT NULL,
?>
