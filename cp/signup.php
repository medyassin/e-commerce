<?php
	/*
	==================================================
	== SIGN UP PAGE
	==================================================
	*/
	ob_start();
	$nonNavBar = '';
	$pageTitle = 'Sin Up Page';
	include 'init.php'; ?>

	<form class="login logins" action="?do=signup" method = "POST">
		<div class="login-git">

			<div class="box-left">
			<!-- USERNAME -->
			<label for="user">user name</label>
			<input class="form-control" type="text" id="user" name="username" placeholder="Username" autocomplete="off">

			<!-- PASSWORD -->
			<label for="pass">password</label>
			<input class="form-control" type="password" id="password" name="pass" placeholder="password" autocomplete="new-password">

			<!-- E-MAIL -->
			<label for="email">E-mail</label>
			<input class="form-control" type="text" id="email" name="email" placeholder="email">

			</div>

			<div class='box-right'>

			<!-- FULL-NAME -->
			<label for="full">Full Name</label>
			<input class="form-control" type="text" id="full" name="fullname" placeholder="Full Name">

			<!-- FULL-NAME -->
			<label for="img">Image link</label>
			<input class="form-control" type="text" id="img" name="img" placeholder="Image Link">
			</div>
			<input class="login-btn btn btn-primary btn-block" type="submit" value="Sign up">
		</div>

	<?php

	include $tpl . 'footer.php';
	ob_end_flush(); // Sent Outpute After Storing It
