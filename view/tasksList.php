<?php
	require_once('../model/tasks.php');

	$array = seeTasks($_SESSION['uuid']);
	
  for($i = 0; $i < count($array); $i++){
	  echo "<ul>";
		  echo "<li class='singleTitle'>"; echo($array[$i] -> title); echo "</li>";
		  echo "<li class='singleDueDate'>"; echo($array[$i] -> dueDate); echo "</li>";
		  echo "<li class='singlePriority'>"; echo($array[$i] -> priority); echo "</li>";
		  echo "<li class='singleIsImportant'>"; echo($array[$i] -> isImportant); echo "</li>";
		  echo "<li class='singleTag'>"; echo($array[$i] -> tag); echo "</li>";
	  echo "</ul>";
  }
?>