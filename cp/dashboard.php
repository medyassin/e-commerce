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

		$pageTitle = 'Dashboard page'; // Dashboard Page Title

		include 'init.php';

		// Dynamique latest users variable

		$latestUsers = 7;
		$latestItems = 7;

		// Get Latest Users using getLatest() function

		$theLatest = getLatest('*','users', 'UserID', $latestUsers);

		// Get Latest Items using getLatest() function

		$theLatestItems = getLatest('*','items', 'Item_ID', $latestItems);

		// Latest Comments

		$commentsL = $con->prepare("SELECT comments.*, users.Username AS user_name
								FROM comments
								INNER JOIN users 
								ON users.UserID = comments.c_user_id");
		$commentsL->execute(); // Execute the statement
		$comments = $commentsL->fetchAll(); // Fetch all data
		?>


		<div class="container">
			<div class="ehead"><h1 class="text-center">Dashboard Page</h1></div>
		</div>

		<!-- START STATS -->

		<div class="container home-stats text-center">
			<div class="row">
				<div class='col-md-3 col-sm-6'>
					<div class='stat st-members'>
						<i class="fa fa-user-circle"></i>
						<div class="info">
							<div>Total Members</div>
						<span><a href="users.php"><?php echo countItems('UserID', 'users', 'GroupeID != 1') ?></a></span>
						</div>
					</div>
				</div>
				<div class='col-md-3 col-sm-6'>
					<div class='stat st-pending'>
						<i class="fa fa-user-plus"></i>
						<div class="info">
							<div>Pending Members</div>
							<span>
								<a href="users.php?do=Manage&page=Pending"><?php echo countItems('UserID', 'users', 'RegStatus =0')?>
								</a>
							</span>
						</div>
					</div>
				</div>
				<div class='col-md-3 col-sm-6'>
					<div class='stat st-items'>
						<i class="fa fa-tag"></i>
						<div class="info">
						<div>Total Items</div>
							<span>
							<a href='items.php?do=Manage'><?php echo countItems('Item_ID', 'items', null) ?>
							</a>
						</span>
						</div>
					</div>
				</div>
				<div class='col-md-3 col-sm-6'>
					<div class='stat st-comments'>
					<i class="fa fa-comments"></i>
					<div class="info">
						<div>Total Comments</div>
						<span><a href="comments.php"><?php echo countItems('c_id', 'comments', null) ?></a></span>
					</div>
					</div>
				</div>

			</div>
		</div>

		<!-- END STATS -->


		<!-- START LATEST ITEMS & USERS & COMMENTS -->

		<div class="container latest">
			<div class="row">

				<!-- LATEST ITEMS -->

				<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-tag"></i>
							Latest <?php echo $latestItems?> latest Items
							<span class="toggle-info pull-right">
								<i class="fa fa-plus"></i>
							</span>
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
											if ($item['Approve'] == 0) {
											echo "<span class='btn btn-success pull-right activateBtn'>";
											    echo "<i class='fa fa-check-circle'></i>";
											    echo "<a href='items.php?do=Approve&itemid=" . $item["Item_ID"] . "'> Approve</a>";
											echo "</span>";
											}

										echo "</li>";
									}
								?>
							</ul>
						</div>
					</div>
				</div>

				<!-- LATEST USERS -->

				<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-user"></i> 
							Latest <?php echo $latestUsers?> registred users
							<span class="toggle-info pull-right">
								<i class="fa fa-plus"></i>
							</span>
						</div>
						<div class="panel-body">
							<ul class="list-unstyled latest-users">
								<?php
									foreach($theLatest as $user) {
										echo "<li>";
											echo $user['Username'];
											echo "<a href='users.php?do=Edit&userid=" . $user["UserID"] . "'>";
											echo "<span class='btn btn-info pull-right'>";
											    			echo "<i class='fa fa-edit'></i> Edit";
											echo "</span>";
											echo "</a>";
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

			<!-- START LATEST COMMENTS -->
			<div class="row">
				<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-comments"></i>
							LATEST COMMENTS
							<span class="toggle-info pull-right">
								<i class="fa fa-plus"></i>
							</span>
						</div>
						<div class="panel-body">
							<?php
								foreach($comments as $comment) {
								
									echo '<div class="comment-box">';
										echo '<div class="user-n"><span>' . $comment['user_name'] . '</span>';
										?>
											<div class="btns">
												<a href="comments.php?do=Edit&cid=<?php echo $comment['c_id'] ?>"><i class="fa fa-edit"></i></a>
												<a href="comments.php?do=Delete&cid=<?php echo $comment['c_id'] ?>"><i class="fa fa-close"></i></a>
											<?php 
												if($comment['c_status'] == 0) {
													echo '<a href="comments.php?do=Approve&cid=' . $comment['c_id'] . '"><i class="fa fa-check"></i></a>';
												}
											?>
											</div>
										<?php

										echo '</div>';
										echo '<p class="user-c">' . $comment['c'] . '<p>' ;
									echo '</div>';
								}
							?>
						</div>
					</div>
				</div>

			</div>
			<!-- END LATEST COMMETNS -->
		</div>

		<!-- END LATEST ITEMS & USERS & COMMENTS -->
		<?php

		// END DASHBOARD PAGE //

		include $tpl . 'footer.php'; // Include Footer

	} else { // If User not logged in, redirect to login Page
		
		header('Location: index.php');
		exit();

	}

	ob_end_flush(); // Sent Outpute After Storing It

?>
