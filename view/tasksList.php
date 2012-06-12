<?php
	if(empty($_SESSION)) {
		session_start();
	}
?>

<?php

  require_once('../model/tasks.php');
  require_once('../model/tags.php');

  $array = seeTasks($_SESSION['uuid']);

  formatTaskList($array);

?>