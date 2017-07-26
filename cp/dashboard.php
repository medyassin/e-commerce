<?php
	/*
	==============================================================
	==> Dashboard page
	==============================================================
	*/

	ob_start(); // To store all output before senting headers => avoid header already sent probleme

	session_start(); // Start Session

	if (isset($_SESSION['Username'])) { // Check if the user logged in

		// Start Dashboard Page // 

		include 'init.php';
		$pageTitle = 'Dashboard page'; // Dashboard Page Title

		// Dynamique latest users variable

		$latestUsers = 7;
		$latestItems = 7;

		// Get Latest Users using getLatest() function

		$theLatest = getLatest('*','users', 'UserID', $latestUsers);

		// Get Latest Items using getLatest() function

		$theLatestItems = getLatest('*','items', 'Item_ID', $latestItems);

		?>
		<div class="ehead"><h1 class="text-center">Dashboard Page</h1></div>

		<div class="container home-stats text-center">
			<div class="row">
				<div class='col-md-3 col-sm-6'>
					<div class='stat st-members'>
						Total Members
						<span><a href="users.php"><?php echo countItems('UserID', 'users', 'GroupeID != 1') ?></a></span>
					</div>
				</div>
				<div class='col-md-3 col-sm-6'>
					<div class='stat st-pending'>
						Pending Members
						<span><a href="users.php?do=Manage&page=Pending"><?php echo countItems('UserID', 'users', 'RegStatus =0')?></a></span>
					</div>
				</div>
				<div class='col-md-3 col-sm-6'>
					<div class='stat st-items'>
						Total Items
						<span><a href='items.php?do=Manage'><?php echo countItems('Item_ID', 'items', null) ?></a></span>
					</div>
				</div>
				<div class='col-md-3 col-sm-6'>
					<div class='stat st-comments'>
						Total Comments
						<span>3500</span>
					</div>
				</div>

			</div>
		</div>
		<div class="container latest">
			<div class="row">
				<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-tag"></i> Latest <?php echo $latestItems?> latest Items
						</div>
						<div class="panel-body">
							<ul class="list-unstyled latest-users">
								<?php
									foreach($theLatestItems as $item) {
										echo "<li>";
											echo $item['Name'];
											echo "<span class='btn btn-info pull-right'>";
											    echo "<i class='fa fa-edit'></i>";
											    echo "<a href='items.php?do=Edit&itemid=" . $item["Item_ID"] . "'> Edit</a>";
											echo "</span>";
										echo "</li>";
									}
								?>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-user"></i> Latest <?php echo $latestUsers?> registred users
						</div>
						<div class="panel-body">
							<ul class="list-unstyled latest-users">
								<?php
									foreach($theLatest as $user) {
										echo "<li>";
											echo $user['Username'];
											echo "<span class='btn btn-info pull-right'>";
											    echo "<i class='fa fa-edit'></i>";
											    echo "<a href='users.php?do=Edit&userid=" . $user["UserID"] . "'> Edit</a>";
											echo "</span>";
											if ($user['RegStatus'] == 0) {
												echo "<span class='btn btn-success pull-right activateBtn'>";
											    echo "<i class='fa fa-check-circle'></i>";
											    echo "<a href='users.php?do=Activate&userid=" . $user["UserID"] . "'> Activate</a>";
											echo "</span>";
											}
										echo "</li>";
									}
								?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php

		// END DASHBOARD PAGE //

		include $tpl . 'footer.php'; // Include Footer

	} else { // If User not logged in, redirect to login Page
		
		header('Location: index.php');
		exit();

	}

	ob_end_flush(); // Sent Outpute After Storing It

?>
