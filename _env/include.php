<?php

	error_reporting(E_ALL);

	function __autoload($class) {
		include('class/'.$class.'.php');
	}
	
	$development = array(
							'localhost',
							'127.0.0.1',
						);
	
	if (isset($_COOKIE['env']) && !isset($_GET['env'])) {
		include('config.' . $_COOKIE['env'] . '.php');
	} elseif (isset($_GET['env'])) {
		setcookie('env', $_GET['env'], 0);
		include('config.' . $_GET['env'] . '.php');
	} else {
		$found = false;
		include('config.php');
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
		
					
	$mysqli = new Database($db['host'],$db['user'],$db['pass'],$db['db']);

?>