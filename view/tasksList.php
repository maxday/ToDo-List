<script type="text/javascript" src="./js/todo-sortableList.js"></script>
tiens ton id : <?php echo $_SESSION['uuid'] ?>
<?php

  require_once('../model/tasks.php');
  require_once('../model/tags.php');

  $array = seeTasks($_SESSION['uuid']);

  echo "<ul id='taskSortList'>";	
  for($i = 0; $i < count($array); $i++){
	      $bdd_uuid = $array[$i] -> uuid;
	      $uuid = str_replace('.','',$bdd_uuid);

		  echo "<li class='task' id=$uuid bdd_id=$bdd_uuid><span class='singleTitle taskcolumn'>"; echo($array[$i] -> title); echo "</span>";
		  echo "<span class='singleDueDate taskcolumn'>"; echo(datefr($array[$i] -> dueDate)); echo "</span>";
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

?>