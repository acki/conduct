<?php

	error_reporting(E_ALL);
	session_start();

	function __autoload($class) {
		if(file_exists('_env/class/'.$class.'.php')) {
			include('class/'.$class.'.php');
		} elseif (file_exists('_env/class/'.$class.'/'.$class.'.php')) {
			include('class/'.$class.'/'.$class.'.php');
		} else {
			print "Couldn't import class file \"".$class."\". Fail.";
		}
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
	
	if($_SERVER['HTTP_HOST'] === $deployment['cloud']) {
		include('config.cloud.php');
	}
		
	$mysqli = new Database($GLOBALS['db']['host'],$GLOBALS['db']['user'],$GLOBALS['db']['pass'],$GLOBALS['db']['db']);

?>