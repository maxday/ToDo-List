<?php

include_once("../helper/utils.php");

/* tested */
function createTag($title, $user) {
	$sql = "INSERT INTO MYTODO_TAG(uuid, title, dateCreated, user) VALUES (?, ?, NOW(), ?)"; 
	$uniqid = (uniqid("",true));	
	$array = array($uniqid, $title, $user);

	launchQuery($sql, $array);
	return $uniqid;
}

/* tested */
/* PRIVATE */
function isTagBelongsToUser($uuid, $user) {
	$vConnect = connect();
	$res = 0;

	$sql = "SELECT uuid FROM MYTODO_TAG WHERE uuid=? AND user=?";
	$prepared_statement = $vConnect->prepare($sql);

	if ($prepared_statement->execute(array($uuid, $user)) == true) {
		$res = $prepared_statement->rowCount();
	}
	close($vConnect);
	return $res;
}

/* tested */
function deleteTag($uuid, $user) {
	if (isTagBelongsToUser($uuid, $user)) {
	  	$sql = "UPDATE MYTODO_TAG SET dateDeleted=NOW() WHERE uuid=?";
		$array = array($uuid);
		launchQuery($sql, $array);

		$sql = "UPDATE MYTODO_TASK SET tag=null WHERE tag=?";
		$array = array($uuid);
		launchQuery($sql, $array);
	}
	else
		echo("Alerte");
}

/* tested */
function updateTagTitle($uuid, $user, $title) {
	if (isTagBelongsToUser($uuid, $user)) {
	  	$sql = "UPDATE MYTODO_TAG SET title=? WHERE uuid=?";
		$array = array($title, $uuid);
		launchQuery($sql, $array);
	}
	else
		echo("Alerte");
}

/* tested */
function seekTag($title, $user) {
	$vConnect = connect();
	$res = 0;

	$sql = "SELECT uuid FROM MYTODO_TAG WHERE title=? AND user=?";
	$prepared_statement = $vConnect->prepare($sql);

	if ($prepared_statement->execute(array($title, $user)) == true) {
		$res = $prepared_statement->fetchAll();
	}
	close($vConnect);
	if(isset($res[0]))
		return $res[0]['uuid'];
	return null;
}

function hasNotReachedMaxTag($user) {
	return countTag($user) < 6;
}

function countTag($user) {
	$vConnect = connect();
	$res = 0;
	$sql = "SELECT uuid FROM MYTODO_TAG WHERE user=?";
	$prepared_statement = $vConnect->prepare($sql);
	if ($prepared_statement->execute(array($user)) == true) {
		$res = $prepared_statement->rowCount();
	}
	close($vConnect);
	return $res;
}

function getTagByUuid($uuid) {
	$vConnect = connect();
	$res = 0;
	$sql = "SELECT title FROM MYTODO_TAG WHERE uuid=?";
	$prepared_statement = $vConnect->prepare($sql);
	if ($prepared_statement->execute(array($uuid)) == true) {
		$res = $prepared_statement->fetch();
	}
	close($vConnect);
	return $res['title'];
}

function getTagsFromUuid($uuid) {
	$vConnect = connect();
	$res = 0;
	$sql = "SELECT uuid, title FROM MYTODO_TAG WHERE user=?";
	$prepared_statement = $vConnect->prepare($sql);
	if ($prepared_statement->execute(array($uuid)) == true) {
		$res = $prepared_statement->fetchAll(); 
	}
	close($vConnect);
	return $res;
}

function computeHtmlFromTags($tagsArray, $sort) {
	$retour = "";
	$i=0; 
	foreach($tagsArray as $singleTag) {
		$i++; 
		if ( $sort == true ) {
			$retour = $retour."<button id='sortCateg".$i."' class='sortTagButton tagButton tagButton".$i."' value=".$singleTag['uuid'].">".$singleTag['title']."</button>";
		}
		else {
			$retour = $retour."<button dragNdrop=".$singleTag['uuid']." class='tagButton tagButton".$i."' value=".$singleTag['title'].">".$singleTag['title']."</button>";
		}
		
	}
	if ( $sort == true ) {
		return $retour;
	}
	$suite = $i;
	$suiteInd = 0;
	for($j=$i; $j<6; ++$j) {
		$suite++;
		$suiteInd++;
		$retour = $retour . "<button target='#new_label_input_".$suiteInd."' class='new_label i_plus icon tagButton".$suite."'>Nouveau</button>";
		$retour = $retour . "<input type='text' id='new_label_input_".$suiteInd."' class='new_label_input'>";
	}

	return $retour;
}













?>
