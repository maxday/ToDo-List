<?php
	require("../model/tasks.php");
print_r($_POST);
extract($_POST);
if($dateD<10)
	$dateD = "0".$dateD;
if($dateM<10)
	$dateM = "0".$dateM;
$dateFinale = $dateY."-".$dateM."-".$dateD;
echo updateTaskWithDate($taskId, $dateFinale);
?>