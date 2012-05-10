<?php
	$fp = fopen("mails.txt","a");
	fputs($fp,"-------------\n".$_GET['nom']."\n".$_GET['mail']."\n".$_GET['message']."\n");
	fclose($fp);
?>