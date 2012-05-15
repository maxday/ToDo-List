<?php

function launchQuery($sql, $array) {
	$vConnect = new Connect;
	$vConnect->mConnect();
	
	$prepared_statement = $vConnect->prepare($sql);
	$prepared_statement->execute($array);
	$vConnect->mClose();
}

function createUser($login) {
	$sql = "INSERT INTO MYTODO_USER(login, dateCreated) VALUES (?, NOW())";
	$array = array($login);
	
	launchQuery($sql, $array);
}
	
function securizeAccount($uiid) {
		$vConnect = new Connect;
		$vConnect->mConnect();
		
		$sql = "UPDATE MYTODO_USER SET pwd=? WHERE uuid=?";
		$requete_preparee = $vConnect->prepare($sql);
		$requete_prepare->execute(array($pwd, $uiid);
		
		$vConnect->mClose();
	}
	
function deleteUser($uuid) {
		$vConnect = new Connect;
		$vConnect->mConnect();
		
		$sql = "DELETE MYTODO_TAG WHERE uuid=?";
		$requete_preparee = $vConnect->prepare($sql);
		$requete_prepare->execute(array($uuid);
		
		$sql = "DELETE MYTODO_TASK WHERE uui=?";
		$requete_preparee = $vConnect->prepare($sql);
		$requete_prepare->execute(array($uuid);
		
		$sql = "DELETE MYTODO_USER WHERE uui=?";
		$requete_preparee = $vConnect->prepare($sql);
		$requete_prepare->execute(array($uuid);
		
		$vConnect->mClose();
	}
	
function updateEmail($email) {
		$vConnect = new Connect;
		$vConnect->mConnect();
		
		$sql = "UPDATE MYTODO_USER SET email=? WHERE uuid=?";
		$requete_preparee = $vConnect->prepare($sql);
		$requete_prepare->execute(array($email, $uiid);
		
		$vConnect->mClose();
	}
	
function updateTips($uuid) {
		$vConnect = new Connect;
		$vConnect->mConnect();
		
		$sql = "UPDATE MYTODO_USER SET hideTips=1 WHERE uuid=?";
		$requete_preparee = $vConnect->prepare($sql);
		$requete_prepare->execute(array($uiid);
		
		$vConnect->mClose();
	}
	
function updateAdvanced($uuid) {
		$vConnect = new Connect;
		$vConnect->mConnect();
		
		$sql = "UPDATE MYTODO_USER SET isAdvancedUser=1 WHERE uuid=?";
		$requete_preparee = $vConnect->prepare($sql);
		$requete_prepare->execute(array($uiid);
		
		$vConnect->mClose();
	}
	
function isProtected($uuid) {
		$vConnect = new Connect;
		$vConnect->mConnect();
		
		$sql = "UPDATE MYTODO_USER SET hideTips=1 WHERE uuid=?";
		$requete_preparee = $vConnect->prepare($sql);
		$requete_prepare->execute(array($uiid);
		
		$vConnect->mClose();
	}
	
?>