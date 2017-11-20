<?php
class admin {

function admin_check($level=0){
	if(!$_SESSION['user_id'] || !$_SESSION['user_role_id']){
		$_SESSION['back_url']=$_SERVER['REQUEST_URI'];
		header('Location: '.AHOST.'login.html');
		exit();
	}elseif($level && $level < $_SESSION['user_role_id']){
		header('HTTP/1.0 404 Not Found');
echo '<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html><head>
<title>404 Not Found</title>
</head><body>
<h1>Not Found</h1>
<p>The requested URL was not found on this server.</p>
<hr>
</body></html>';
		
		exit();
	}
}

}