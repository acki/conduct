<?

	include('_env/include.php');
	
	$mysqli->select('*', 'member', array('id>4', 'name!=Bla'));

?>