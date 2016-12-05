<?php

if(empty($params)) { array_push($params, "home"); }

$next_file = "";

switch (array_shift($params)){
	case "home":
		$next_file = "home.php";
		break;
	case "joined":
		$next_file = "home.php";
		$joined = true;
		break;
	case "validate":
		$next_file = "activate.php";
		break;
	default:
		$next_file = "home.php";
		break;
}

require $next_file;

?>