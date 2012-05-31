<?php
	echo "<pre>";
	$array = analyzeLineTask("acheter du lait -d 10-10-2012");
	print_r($array);

	if($array[4] == "")
		createTask($array[0], $array[3], $array[2], $array[1], null, $SESSION['user'])
	else{
		$uuidTag = seekTag($array[0], $SESSION['user']);
		if($uuidTag == 0)
			$uuidTag = createTag($array[4], $SESSION['user']);
		createTask($array[0], $array[3], $array[2], $array[1], $uuidTag, $SESSION['user'])
	}
	echo "</pre>";

	function analyzeLineTask($line){
		echo($line);		
		$subject = $line;
		$pattern = '/\A(.+)\s-/U';
		preg_match($pattern, $subject, $name);

		$pattern = '/\s-i\s/';
		preg_match($pattern, $subject, $i);
		if(isset($i[0]))
			$important = 1;
		else
			$important = 0;

		$pattern = '/\+p|\+\+p|-p|--p/';
		preg_match($pattern, $subject, $p);

		if(isset($p[0])){
			if($p[0] == "--p")
				$priority = 0;
			elseif($p[0] == "-p")
				$priority = 1;
			elseif($p[0] == "+p")
				$priority = 3;
			elseif($p[0] == "++p")
				$priority = 4;
		}
		else
			$priority = 2;

		$pattern = '/\s-d\s([0-9]{8}|[0-9]{2}-[0-9]{2}-[0-9]{4}|[0-9]{2}\/[0-9]{2}\/[0-9]{4})/';
		preg_match($pattern, $subject, $d);
		if(isset($d[0]))
			$date = $d[1];
		else
			$date = "";

		$pattern = '/\s-l\s([a-zA-Z]+)/';
		preg_match($pattern, $subject, $l);
		if(isset($l[0]))
			$tag = $l[1];
		else
			$tag = "";
		
		if(isset($name[1]))
			return array($name[1], $important, $priority, $date, $tag);
		else
			return array($line, 0, 2, "", "");
	}
?>
