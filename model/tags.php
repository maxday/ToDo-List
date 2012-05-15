<?php
function createTag($title, $user) {
		$vConnect = new Connect;
		$vConnect->mConnect();
		
		$sql = "INSERT INTO MYTODO_TASK(title, dateCreated, user) VALUES (?, NOW(), ?)"; 
		$requete_preparee = $vConnect->prepare($sql);
		$requete_prepare->execute(array($title, $user));
		
		$vConnect->mClose();
	}
?>