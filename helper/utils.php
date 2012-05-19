<?php

include("connect.php");

function launchQuery($sql, $array) {
	$vConnect = connect();

	$prepared_statement = $vConnect->prepare($sql);
	$prepared_statement->execute($array);
	close($vConnect);
}

?>
