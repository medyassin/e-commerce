<?php
	

	include 'cp/connect.php';

	$sessionUser = '';

	if(isset($_SESSION['user'])) {
		$sessionUser = $_SESSION['user'];
	}

	// Routes
	$tpl    = 'includes/templates/'; // Template Directory
	$lang   = 'includes/languages/'; // Languages Directory
	$func   = 'includes/functions/';  // Functions Directory
	$css    = 'layout/css/';         // CSS Directory
	$js     = 'layout/js/';          // JS Directory
	
	// Include Importants Files
	include $func   . 'functions.php';
	include $lang   . 'en.php';
	include $tpl    . 'header.php';
?>