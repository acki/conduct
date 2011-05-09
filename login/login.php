<?

	include('../_env/include.php');

	$login = new Login($_POST['username'],$_POST['password']);
	
	print '
		<p>
			<a href="../"><button>Go back!</button></a>
		</p>
	';

?>