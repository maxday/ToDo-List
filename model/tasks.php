<?php
function createTask($title, $dueDate, $priority, $isImportant, $tag, $user) {
		$vConnect = new Connect;
		$vConnect->mConnect();
		
		$sql = "INSERT INTO MYTODO_TASK(dateCreated, title, dueDate, priority, isImportant, tag, user) VALUES (NOW(), ?, ?, ?, ?, ?, ?)"; 
		$requete_preparee = $vConnect->prepare($sql);
		$requete_prepare->execute(array($title, $dueDate, $priority, $isImportant, $tag, $user));
		
		$vConnect->mClose();
	}
?>