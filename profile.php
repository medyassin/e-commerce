<?php
	session_start();
	include 'init.php';

	if(isset($_SESSION['user'])) {
		echo 'Welcome to your profile' . ' ' . $_SESSION['user'];
	} else {
		header('Location: index.php');
	}

	include $tpl . 'footer.php';
?>