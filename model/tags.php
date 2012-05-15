<?php
function createTag($title, $user) {
		$vConnect = new Connect;
		$vConnect->mConnect();
		
		$sql = "INSERT INTO MYTODO_TASK(title, dateCreated, user) VALUES (:title, NOW(), :user)"; 
		$requete_preparee = $vConnect->prepare($sql);
		$requete_prepare->execute(array( ':title' => $title, ':user' => $user));
		
		$vConnect->mClose();
	}
?>