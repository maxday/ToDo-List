<?php
function createUser($login) {
		$vConnect = new Connect;
		$vConnect->mConnect();
		
		$sql = "INSERT INTO MYTODO_USER(login, dateCreated) VALUES (:login, NOW())"; 
		$requete_preparee = $vConnect->prepare($sql);
		$requete_prepare->execute(array( ':login' => $login ));
		
		$vConnect->mClose();
	}
?>