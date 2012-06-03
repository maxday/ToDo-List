<script type="text/javascript" src="./js/todo-sortableList.js"></script>

<?php

  require_once('../model/tasks.php');
  require_once('../model/tags.php');

  $array = seeTasks($_SESSION['uuid']);

  echo "<ul id='taskSortList'>";	
  for($i = 0; $i < count($array); $i++){
	      $bdd_uuid = $array[$i] -> uuid;
	      $uuid = str_replace('.','',$bdd_uuid);

		  echo "<li class='task' id=$uuid bdd_id=$bdd_uuid><span class='singleTitle'>"; echo($array[$i] -> title); echo "</span>";
		  echo "<span class='singleDueDate'>"; echo($array[$i] -> dueDate); echo "</span>";
		  echo "<span class='singlePriority'>"; echo($array[$i] -> priority); echo "</span>";
		  echo "<span class='singleIsImportant'>"; echo($array[$i] -> isImportant); echo "</span>";
		  echo "<span class='singleTag'>"; echo getTagByUuid($array[$i]->tag); echo "</span></li>";
  }
  echo "</ul>";

?>