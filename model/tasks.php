<?php

include_once('../helper/utils.php');

/* tested */
function createTask($title, $dueDate, $priority, $isImportant, $tag, $user) {
	//die($title . "|" . $dueDate . "|" . $priority . "|" . $isImportant . "|" . $tag . "|" . $user); 
	$vConnect = connect();
	$prepared_statement = $vConnect->prepare("SELECT max(rank) as max FROM MYTODO_TASK WHERE user=?");
	if ($prepared_statement->execute(array($user)) == true) {
		$res = $prepared_statement->fetch();
	}
	close($vConnect);
	
	$rank = $res['max'] + 1;
	if($dueDate=="")
		$dueDate = null;

	$sql = "INSERT INTO MYTODO_TASK(uuid, dateCreated, title, dueDate, priority, isImportant, rank, tag, user) VALUES (?, NOW(), ?, ?, ?, ?, ?, ?, ?)"; 
	$uniqId = uniqid("",true);
	$array = array($uniqId, $title, dateen($dueDate), $priority, $isImportant, $rank, $tag, $user);
	
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

function completeAllTask($user) {
	$sql = "UPDATE MYTODO_TASK SET dateCompleted=NOW() WHERE user=?";
	$array = array($user);
	launchQuery($sql, $array);
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

	$pattern = '/\-p|-q|-r/';
	preg_match($pattern, $subject, $p);

	if(isset($p[0])){
		if($p[0] == "-p")
			$priority = 1;
		elseif($p[0] == "-q")
			$priority = 2;
		elseif($p[0] == "-r")
			$priority = 3; 
	}
	else {
		$priority = 1;
	}
	$pattern = '/\s-d\s([0-9]{8}|[0-9]{2}-[0-9]{2}-[0-9]{4}|[0-9]{2}\/[0-9]{2}\/[0-9]{4})/'; 
	preg_match($pattern, $subject, $d);
	if(isset($d[0])) {
		$date = $d[1];   
	}
	else
		$date = "";

	$pattern = '/\s-l\s([a-zA-Z]+)/';
	preg_match($pattern, $subject, $l);
	if(isset($l[0]))
		$tag = $l[1];
	else
		$tag = "";
	 
	if(isset($name[1])) {
		//die($name[1] . "|" . $important . "|" . $priority . "|" . $date . "|" . $tag);
		return array($name[1], $important, $priority, $date, $tag);
	}
	else { 
		return array($line, 0, $priority, "", "");
		}
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
	$sql = "SELECT * FROM MYTODO_TASK WHERE user=? AND dateCompleted IS NULL ORDER BY rank DESC";
	$prepared_statement = $vConnect->prepare($sql);

	if($prepared_statement->execute(array($uuid)) == true) {
		while ( $line = $prepared_statement->fetch(PDO::FETCH_OBJ) ) {
	    	array_push($returnArray, $line);
	  	}
	}
	close($vConnect);	
	return $returnArray;
}


function reOrderTask($arrayTask) {
	$vConnect = connect();
	$i=0;
	foreach($arrayTask as $singleTask) {
		$sql = "UPDATE MYTODO_TASK SET rank = ? WHERE uuid=?";
		$prepared_statement = $vConnect->prepare($sql);
		$prepared_statement->execute(array($i, $singleTask));
		$i--;
	}
	close($vConnect);
}

/*
* Trie les tâches par date
*/
function sortTasksByDate($date, $uuid) {
	$vConnect = connect();
	$returnArray = array();
	if ( empty($date) ) { 
		$sql = "SELECT * FROM MYTODO_TASK WHERE user = ? ORDER BY dueDate DESC"; 
	}
	else {
		$sql = "SELECT * FROM MYTODO_TASK WHERE user=? AND dueDate = " . $date;
	}
	$prepared_statement = $vConnect->prepare($sql);  
	if($prepared_statement->execute(array($uuid)) == true) { 
		while ( $line = $prepared_statement->fetch(PDO::FETCH_OBJ) ) {
	    	array_push($returnArray, $line); 
	  	}
	} 
	close($vConnect);
	return $returnArray;
}

/*
* Trie les tâches par importance
*/
function sortTasksByImportance($importance, $uuid) {
	$vConnect = connect();
	$returnArray = array(); 
	$sql = "SELECT * FROM MYTODO_TASK WHERE user = ? AND isImportant = ?";  
	$prepared_statement = $vConnect->prepare($sql);  
	if($prepared_statement->execute(array($uuid, $importance)) == true) { 
		while ( $line = $prepared_statement->fetch(PDO::FETCH_OBJ) ) {
	    	array_push($returnArray, $line); 
	  	}
	} 
	close($vConnect);
	return $returnArray;
}

/*
* Trie les tâches par priorité choisie
*/
function sortTasksByPriority($selPriority, $uuid) {
	$vConnect = connect();
	$returnArray = array(); 
	$sql = "SELECT * FROM MYTODO_TASK WHERE user = ? AND priority = ?"; 
	$prepared_statement = $vConnect->prepare($sql);  
	if($prepared_statement->execute(array($uuid, $selPriority)) == true) { 
		while ( $line = $prepared_statement->fetch(PDO::FETCH_OBJ) ) {
	    	array_push($returnArray, $line); 
	  	}
	} 
	close($vConnect);
	return $returnArray;
}

/*
* Trie les tâches par catégorie choisie
*/
function sortTasksByCategory($cat, $uuid) {
	$vConnect = connect();
	$returnArray = array(); 
	$sql = "SELECT * FROM MYTODO_TASK WHERE user = ? AND tag = ?"; 
	$prepared_statement = $vConnect->prepare($sql);  
	if($prepared_statement->execute(array($uuid, $cat)) == true) { 
		while ( $line = $prepared_statement->fetch(PDO::FETCH_OBJ) ) {
	    	array_push($returnArray, $line); 
	  	}
	} 
	close($vConnect);
	return $returnArray;
}



function updateTaskWithTag($uuidTask, $uuidTag) {
	$vConnect = connect();
	$returnArray = array(); 
	$sql = "UPDATE MYTODO_TASK SET tag = ? WHERE uuid = ?"; 
	$prepared_statement = $vConnect->prepare($sql);  
	if($prepared_statement->execute(array($uuidTag, $uuidTask)) == true) 
	close($vConnect);
}


function updateTaskWithDate($uuidTask, $date) {
	$vConnect = connect();
	$returnArray = array(); 
	$sql = "UPDATE MYTODO_TASK SET dueDate = ? WHERE uuid = ?"; 
	$prepared_statement = $vConnect->prepare($sql);  
	if($prepared_statement->execute(array($date, $uuidTask)) == true) 
	close($vConnect);
}


function sortTasksByMultiCrits($date, $importance, $priority, $categories, $uuid) {
	$vConnect = connect();
	$returnArray = array(); 
	$paramarray = array();
	$sql = "SELECT * FROM MYTODO_TASK WHERE user = ? AND dateCompleted IS NULL ";
	array_push($paramarray, $uuid);
	
	if ( $date != "undefined") {
		$sql .= "AND dueDate = ? "; 	
		array_push($paramarray, $date);
	}
	if ( $importance != "undefined") {  
		$sql .= "AND isImportant = ? "; 
		array_push($paramarray, $importance);
	}
	if ( $priority != "undefined" ) { 
		$sql .= "AND priority = ?"; 
		array_push($paramarray, $priority);
	}  
	if ( $categories != "undefined") { 
		$sql .= "AND tag IN (";
		$selectedC = count($categories);
		for ( $i=0 ; $i < $selectedC ; ++$i ) {
			if ( $categories[$i] != "" && $categories[$i] != "undefined") {
				$sql .= '?';
				if ( $i+1 != $selectedC ) { $sql.= ','; }
				array_push($paramarray, $categories[$i]);
			}
		}
		$sql .= ')';
	}
	$prepared_statement = $vConnect->prepare($sql);  
	$res = $prepared_statement->execute($paramarray);
	if( $res == true) { 
		while ( $line = $prepared_statement->fetch(PDO::FETCH_OBJ) ) {
	    	array_push($returnArray, $line); 
	  	}
	} 
	close($vConnect);
	return $returnArray;
}


function formatTaskList($array) {
  echo "<ul id='taskSortList'>";
	// Colonne entete
  echo "<li id='header_tab' class='task entete'><span class='singleTitle taskcolumn'>Intitulé</span><span class='taskcolumn' style='
  width:91px;display: inline-block;'>Date</span> <span class='singlePriority taskcolumn'>Priorité</span> <span class='singleIsImportant taskcolumn'>Importance</span> <span class='singleTag taskcolumn'>Catégorie</span> <span class='taskcolumn deleteTask' id='deleteAllTask'>Vider</span></li>";
  for($i = 0; $i < count($array); $i++){
	      $bdd_uuid = $array[$i] -> uuid;
	      $uuid = str_replace('.','',$bdd_uuid);

		  echo "<li class='task' bdd_id=$uuid id=$bdd_uuid><span class='singleTitle taskcolumn'>"; echo($array[$i] -> title); echo "</span>";
		 
		  if($array[$i] -> dueDate == '0000-00-00')
		  	$fDueDate = "";
		  else
		    $fDueDate = datefr($array[$i] -> dueDate);
		  echo "<span class='singleDueDate taskcolumn'>"; echo $fDueDate; echo "</span>";
		  echo "<span class='singlePriority taskcolumn'>"; 
		  $nbImg = '';
		  for ( $j = 0 ; $j < $array[$i] -> priority ; $j++) {
		     $nbImg .= "<img src='./img/star.png' />&nbsp;";
		  } 
		  echo $nbImg;
		  echo "</span>";
		  echo "<span class='singleIsImportant taskcolumn'>";
		  if ( $array[$i] -> isImportant == 1 ) {
			echo "<img src='./img/priority.png' />";
		  }
		  echo "</span>";
		  echo "<span class='singleTag taskcolumn'>"; echo getTagByUuid($array[$i]->tag); echo "</span>";
		  echo "<span class='deleteTask taskcolumn'> </span></li>";
  }
  echo "</ul>";
}
?>
