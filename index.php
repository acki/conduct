<?

	include('_env/include.php');
	
	$id = 4;
	$data = $mysqli->select('member', array(id=>array('21','<')));
	print_r($data);

?>