<?php

	error_reporting(E_ALL);
	session_start();

	function __autoload($class) {
		include('class/'.$class.'.php');
	}
	
	require_once('config.php');
		
	if (isset($_COOKIE['env']) && !isset($_GET['env'])) {
		include('config.' . $_COOKIE['env'] . '.php');
	} elseif (isset($_GET['env'])) {
		setcookie('env', $_GET['env'], 0);
		include('config.' . $_GET['env'] . '.php');
	} else {
		$found = false;
		foreach($development as $d) {
			if ($_SERVER['HTTP_HOST'] == $d) {
				include('config.development.php');
				$found = true;
			} //if
		} // foreach
		
		if(!isset($found)) {
			include('config.production.php');
		}
	}
		
	$mysqli = new Database($GLOBALS['db']['host'],$GLOBALS['db']['user'],$GLOBALS['db']['pass'],$GLOBALS['db']['db']);

?>