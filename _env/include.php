<?php

	error_reporting(E_ALL);

	function __autoload($class) {
		include('class/'.$class.'.php');
	}
	
	$development = array(
							'localhost',
							'127.0.0.1',
						);
						
	$found = false;
	include('config.php');
	foreach($development as $d) {
		if ($_SERVER['HTTP_HOST'] == $d) {
			include('config.development.php');
			$found = true;
		} //if
	} // foreach
	
	if(!$found) {
		include('config.production.php');
	}
	
	$mysqli = new Database($db['host'],$db['user'],$db['pass'],$db['db']);

?>