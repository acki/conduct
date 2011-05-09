<?

	include('../_env/include.php');
	
	Login::logout();
	
	print '
		<p>done.</p>
		<p><a href="javascript:history.back();">zur&uuml;ck</a></p>
	';
	
?>