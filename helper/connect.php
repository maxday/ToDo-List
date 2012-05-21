<?php

// if any questions : http://www.phpro.org/tutorials/Introduction-to-PHP-PDO.html#10


	function connect() {

		$dbtype = "mysql";
		$host = "localhost";
		$dbname = "todolist";
		$login = "root";
		$pass = "root";

		try {
			$pdo = new PDO("$dbtype:host=$host;dbname=$dbname", $login, $pass);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $pdo;
		} catch(Exception $e) {
			echo 'Erreur : '.$e->getMessage().'<br />';
			echo 'N° : '.$e->getCode();
		}

	}
	
	function close($pdo) {
		$pdo = null;
	}


?>
