<?

	/**
	 * Configuration File
	 * 
	 * This is the default configuration file for the site configuration.
	 * More configuration at config.development.php or config.production.php
	 *
	 * @author Christoph S. Ackermann <info@acki.be>
	 */

	// Database configuration
	$db = array(
		'host' => 'localhost',
		'user' => 'conduct',
		'pass' => 'conduct',
		'db'   => 'conduct',
	);
	
	// Salt for passwords #CHANGE THIS#
	$secure = array(
		'salted' => 'ef3/*fjs0e!!',
	);
	
	// Array with development hosts (takes automatically the config.development.php)
	$development = array(
		'localhost',
		'127.0.0.1',
	);
	
	$deployment = array(
		'cloud' => 'conduct.phpfogapp.com',
	);
	
?>