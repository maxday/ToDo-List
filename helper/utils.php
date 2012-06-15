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
		echo $date;
	if (!empty($date)) {
		$pos = strpos($date, '-');
		$pos2 = strpos($date, '/');
		
		if($pos > 0){
			$split = preg_split("!-!",$date);
			$jour = $split[0]; 
			$mois = $split[1]; 
			$annee = $split[2]; 
		}
		elseif ($pos2 > 0){
			$split = preg_split("!/!",$date);
			$jour = $split[0]; 
			$mois = $split[1]; 
			$annee = $split[2]; 
		}
		else{
		  $jour = substr($date, 0, 2);
		  $mois = substr($date, 2, 2);
		  $annee = substr($date, 4, 4);
		}
	}
	else {
		$annee = '0000'; $mois = '00' ; $jour = '00';
	}
	return "$annee"."-"."$mois"."-"."$jour"; 
}

?>
