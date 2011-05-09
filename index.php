<?

	include('_env/include.php');
	
	$id = &$_GET['id'];
	if(!isset($id)) {
		$id = 1;
	}
	//$data = $mysqli->select('member');
	//print_r($data);
	
	//print '<br /><br />';
	
	$member = new Member($mysqli, $id);
	print $member->getFullName();

?>