<?php
function createTask($title, $dueDate, $priority, $isImportant, $tag, $user) {
		$vConnect = new Connect;
		$vConnect->mConnect();
		
		$sql = "INSERT INTO MYTODO_TASK(dateCreated, title, dueDate, priority, isImportant, tag, user) VALUES (NOW(), :title, :dueDate, :priority, :isImportant, :tag, :user)"; 
		$requete_preparee = $vConnect->prepare($sql);
		$requete_prepare->execute(array( ':title' => $title, ':dueDate' => $dueDate, ':priority' => $priority, ':isImportant' => $isImportant, ':tag' => $tag, ':user' => $user));
		
		$vConnect->mClose();
	}
?>