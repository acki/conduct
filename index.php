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

	if(!Login::isAuthed()) {

		print '
		<p>
			<h1>Login</h1>
			<form action="login/login.php" method="post">
				<h3>Username: <input type="text" name="username"></h3>
				<h3>Password: <input type="password" name="password"></h3>
				<input type="submit" value="login">
			</form>
		</p>
		';
	
	} else {
		
		print '<p><a href="login/logout.php">logout user '.$_SESSION['user_id'].'</a></p>';
		
	}

?>