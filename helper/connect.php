<?php

// if any questions : http://www.phpro.org/tutorials/Introduction-to-PHP-PDO.html#10

class Connect{
	var $fHost;
	var $fPort;
	var $fDbname;
	var $fUser;
	var $fPassword;
	var $fConn;

	function __construct(){
		$this->fSGBD = "mysql";
		$this->fHost = "localhost";
		$this->fPort = "5432";
		$this->fDbname = "todolist";
		$this->fUser = "root";
		$this->fPassword = "root";
	}

	function mConnect(){
		try {
			$this->fConn = new PDO("$this->fSGBD:host=$this->fHost;dbname=$this->fDbname",$this->fUser,$this->fPassword);
		} catch(Exception $e) {
				echo 'Erreur : '.$e->getMessage().'<br />';
				echo 'N° : '.$e->getCode();
		}
	}

	function mClose(){
		$this->fConn = null;
	}
}

/*
$vConnect = new Connect;
$vConnect->mConnect();


$resultats=$vConnect->fConn->query("SELECT TITLE FROM MYTODO_TAG"); // on va chercher tous les membres de la table
$resultats->setFetchMode(PDO::FETCH_OBJ); // on dit qu'on veut que le résultat soit récupérable sous forme d'objet

while( $ligne = $resultats->fetch() ) {
	echo 'Utilisateur : '.$ligne->TITLE.'<br />'; // on affiche les membres
}
$resultats->closeCursor(); // on ferme le curseur des résultats

$vConnect->mClose();

*/

function launchQuery($sql, $array) {
	$vConnect = new Connect;
	$vConnect->mConnect();
	
	$prepared_statement = $vConnect->prepare($sql);
	$prepared_statement->execute($array);
	$vConnect->mClose();
}

?>
