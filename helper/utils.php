<?php

include("connect.php");
include("constant.php");

function launchQuery($sql, $array) {
	$vConnect = connect();

	$prepared_statement = $vConnect->prepare($sql);
	$prepared_statement->execute($array);
	close($vConnect);
}

function datefr($date) { 
	$split = preg_split("!-!",$date); 
	$annee = $split[0]; 
	$mois = $split[1]; 
	$jour = $split[2]; 
	return "$jour"."-"."$mois"."-"."$annee"; 
}

?>
