<?php
	
	/*
		Categories => [ MANAGE | EDIT | UPDATE | ADD | INSERT | DELETE | STATS ]
	*/

	include 'init.php';

	$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

	if ($do == 'Manage') {
		echo 'Welcome to Manage page';
		echo "<a href='?do=Edit'>Edit Categorie</a>";

	} elseif ($do == 'Edit') {

		echo 'Welcome to Edit page';
	} elseif ($do == 'Update') {

		echo 'Welcome to Update page';
	} else {
		echo 'Error';
	}