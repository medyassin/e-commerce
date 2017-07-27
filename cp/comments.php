<?php
	/*
	==================================================
	==> Manage Comments Page                      
	==> You can  Edit | Delete | Approve    
	==================================================
	*/
	ob_start(); // To store all output before senting headers => avoid header already sent probleme

	session_start(); // Start Session

	if (isset($_SESSION['Username'])) { // Check IF the User is Logged IN

		$pageTitle = 'Comments'; // Page Title

		include 'init.php'; // Include Init.php


		// USERS PAGE CONTENT START FORM HERE

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage'; // CREATE PAGES USING ?do= REQUEST

		/*
		=======================
		| MANAGE COMMENTS PAGE   |
		=======================
		*/

		if ($do == 'Manage') {


			$stmt = $con->prepare("SELECT comments.*, items.Name AS item_name, users.Username AS user_name
									FROM comments
									INNER JOIN items 
									ON items.Item_ID  = comments.c_item_id
									INNER JOIN users 
									ON users.UserID = comments.c_user_id");
			$stmt->execute(); // Execute the statement
			$rows = $stmt->fetchAll(); // Fetch all data

		?>
			<!-- HEADING OF THE PAGE -->
			<div class="ehead"> <h1 class="text-center">Comments Manage Page</h1></div>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table text-center table table-bordered">
						<tr>
							<td>#ID</td>
							<td>Comment</td>
							<td>Item Name</td>
							<td>User name</td>
							<td>Added date</td>
							<td>Control</td>
						</tr>

						<?php

						foreach($rows as $row) {

							echo "<tr>"; // START TAbLE ROW
								echo "<td>" . $row['c_id'] . "</td>";
								echo "<td>" . $row['c'] . "</td>";
								echo "<td>" . $row['item_name'] . "</td>";
								echo "<td>" . $row['user_name'] . "</td>";
								echo "<td>" . $row['c_date'] . "</td>";
								
								echo "<td>";
									echo "<a href='?do=Edit&cid=" . $row['c_id'] . "'" . "class='btn btn-success'>";
									echo "<i class='fa fa-edit'></i>Edit</a> ";

									echo "<a href='?do=Delete&cid=" . $row['c_id'] . "'" . "class='btn btn-danger confirm'>";
									echo "<i class='fa fa-close'></i>Delete</a> ";

								// Case User is Not Activated yet ==> show Btn of Activation
								if ($row['c_status'] == 0) {
									echo
										"<a href='?do=Approve&cid=" . $row['c_id'] . "'" . "class='btn btn-info activate'><i class='fa fa-check'></i>approve
										</a>";
								}
								
								echo "</td>";

							echo "</tr>"; // END TAbLE ROW
						}

						?>

					</table>
				</div>
			</div>
		
		<?php

		/*
		=======================
		| EDIT COMMENT PAGE   |
		=======================
		*/

		} elseif ($do == 'Edit') {

			// Check if GET Request comment id is numeric and get the integer value of it
			$cid = isset($_GET['cid']) && is_numeric($_GET['cid']) ? intval($_GET['cid']) : 0;

			// ~Select all data depend on this ID
			$stmt = $con->prepare("SELECT * FROM comments WHERE c_id = ?");

			// ~Execute the query
			$stmt->execute(array($cid));

			// Fetch the Data
			$row = $stmt->fetch();

			// If there's such ID show the form
			$count = $stmt->rowCount();

			if ($count > 0 ) { ?>
			
				<div class="ehead">
					<h1 class="text-center">Edit Comment Page</h1>
				</div>
				<div class="container">
					<!-- Start username field -->
					<form class="form-horizontal" action="?do=Update" method="POST">

						<input type="text" class="hidden" name="cid" value="<?php echo $cid ?>">

						<div class="form-group">
							<label class="col-sm-2 control-label">Comment</label>
							<div class="col-sm-10 col-md-4">
							<textarea class="form-control" name="comment" row="6"><?php echo $row['c'] ?></textarea>
							</div>
						</div>
					<!-- Start button field -->
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" value="save" class="btn btn-primary">
							</div>
						</div>
					</form>
				</div>		
			<?php } else { // ~ Show Error Message ~ No Id Found ~
				echo '<div class="container">';
				$theMsg = "<div class='alert alert-danger'>no comment found to edit</div>";
				redirectHome($theMsg);
				echo '</div>';
			}

		/*
		=======================
		| UPDATE USERS PAGE   |
		=======================
		*/

		} elseif($do == 'Update') {

			echo '<div class="ehead"> <h1 class="text-center">Update Comment Page</h1></div>';
			echo '<div class="container">';
			echo '<div class="col-md-6">';

			// ~ Check if the user come form a POST Request or directly ?
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				// Get variables from the FORM
				$cid = $_POST['cid'];
				$c = $_POST['comment'];

				// UPDATE the database with thos info
				$stmt = $con->prepare("UPDATE comments SET c = ? WHERE c_id = ?");
				$stmt->execute(array($c, $cid));

				// Echo Sucess message with the number of records
				$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Records updated' . '</div>';
				redirectHome($theMsg, 'comments.php',2);
				
			} else {
				$theMsg = '<div class="alert alert-danger">You can\'t browse this page directly</div>';
				redirectHome($theMsg);
			}
			echo '</div>';
			echo '</div>';

		/*
		=======================
		| DELETE USERS PAGE   |
		=======================
		*/

		} elseif ($do == 'Delete') { 

			echo '<div class="ehead"> <h1 class="text-center">Delete comments Page</h1></div>';
			echo '<div class="container">';

			// ~Check if GET Request commentid is numeric and get the integer value of it
			$cid = isset($_GET['cid']) && is_numeric($_GET['cid']) ? intval($_GET['cid']) : 0;

			// ~Select all data depend on this ID
			$stmt = $con->prepare("SELECT * FROM comments WHERE c_id = ?");

			// ~Execute the query
			$stmt->execute(array($cid));

			// If there's such ID DELETE the User
			$count = $stmt->rowCount();

			if ($count > 0 ) {
				
				$stmt  = $con->prepare("DELETE FROM comments WHERE c_id = :zc");
				$stmt->bindParam(":zc", $cid);
				$stmt->execute();

				// Echo Sucess message with the number of records
				
				$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Records deleted' . '</div>';
				redirectHome($theMsg,'back',2);

			} else {
				$theMsg = '<div class="alert alert-success">Comment not found!</div>';
				redirectHome($theMsg, 'users.php',4);
			}

			echo '</div>';

		/*
		==========================
		|  APPROVE COMMENTS PAGE   |
		=========================
		*/


		} elseif($do == 'Approve') {
			// Approve Comments Page
			echo '<div class="ehead"> <h1 class="text-center">Approve Comments Page</h1></div>';
			echo '<div class="container">';

			$cid = isset($_GET['cid']) && is_numeric($_GET['cid']) ? intval($_GET['cid']) : 0;

			$check = checkItem('c_id', 'comments', $cid);

			if ($check > 0 ) {
				
				$stmt = $con->prepare("UPDATE comments SET c_status = 1 WHERE c_id = ?");
				$stmt->execute(array($cid));

				// Echo Sucess message with the number of records
				$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Records Approved' . '</div>';
				redirectHome($theMsg,'back',2);

			} else {
				$theMsg = '<div class="alert alert-success">Comment not found!</div>';
				redirectHome($theMsg, 'comments.php',4);
			}

			echo '</div>';
		}	

		include $tpl . 'footer.php';

	} else {

		header('Location: index.php');
		exit();

	}


ob_end_flush(); // Sent Outpute After Storing It