<?php
	extract($_GET);
	$monfichier = fopen('mails.txt', 'r+');
	while ( !feof($monfichier) ) {
		$ligne = fgets($monfichier);
		$newligne .= $ligne . "\n";
	}	
	$newligne .=  "\n" . $mail;
	ftruncate($monfichier,0);
	fputs($monfichier, $newligne);
	// 3 : quand on a fini de l'utiliser, on ferme le fichier
	fclose($monfichier);
?>