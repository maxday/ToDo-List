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
	if ( !empty($date)) {
		$split = preg_split("!-!",$date); 
		$annee = $split[0]; 
		$mois = $split[1]; 
		$jour = $split[2]; 
	}
	else {
		$annee = '0000'; $mois = '00' ; $jour = '00';
	}
	return "$jour"."-"."$mois"."-"."$annee"; 
}

function dateen($date) { 
	if ( !empty($date)) {	
		$split = preg_split("!-!",$date); 
		$jour = $split[0]; 
		$mois = $split[1]; 
		$annee = $split[2]; 
	}
	else {
		$annee = '0000'; $mois = '00' ; $jour = '00';
	}
	return "$annee"."-"."$mois"."-"."$jour"; 
}

?>
