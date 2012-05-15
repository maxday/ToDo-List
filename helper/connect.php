<?php

// if any questions : http://www.phpro.org/tutorials/Introduction-to-PHP-PDO.html#10


	function connect() {
		try {
			$pdo = new PDO("mysql:host=localhost;dbname=todolist", 'root', 'root');
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
