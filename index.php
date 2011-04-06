<?

	include('_env/include.php');
	
	$id = $_GET['id'];
	//$data = $mysqli->select('member');
	//print_r($data);
	
	//print '<br /><br />';
	
	$member = new Member($mysqli, $id);
	print $member->getFullName();

?>