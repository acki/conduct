<?php

	function __autoload($class) {
		include('class/'.$class.'.php');
	}
	
	$development = array(
							'localhost',
							'127.0.0.1',
						);
	
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
	
?>