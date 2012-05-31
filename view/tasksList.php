<?php
	require_once('../model/tasks.php');

	$array = seeTasks($_SESSION['uuid']);
	
  for($i = 0; $i < count($array); $i++){
	  echo "<li>";
		  echo "<ul class='singleTitle'>"; echo($array[$i] -> title); echo "</ul>";
		  echo "<ul class='singleDueDate'>"; echo($array[$i] -> dueDate); echo "</ul>";
		  echo "<ul class='singlePriority'>"; echo($array[$i] -> priority); echo "</ul>";
		  echo "<ul class='singleIsImportant'>"; echo($array[$i] -> isImportant); echo "</ul>";
		  echo "<ul class='singleTag'>"; echo($array[$i] -> tag); echo "</ul>";
	  echo "</li>";
  }
?>