<?php
	/*
	==================================================
	==> Manage Users Page                           <=
	==> You can Add | Edit | Delete | Activate      <=
	==================================================
	*/
	ob_start(); // To store all output before senting headers => avoid header already sent probleme

	session_start(); // Start Session

	if (isset($_SESSION['Username'])) { // Check IF the User is Logged IN

		$pageTitle = 'Users Page'; // Page Title

		include 'init.php'; // Include Init.php


		// USERS PAGE CONTENT START FORM HERE

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage'; // CREATE PAGES USING ?do= REQUEST

		/*
		=======================
		| MANAGE USERS PAGE   |
		=======================
		*/

		if ($do == 'Manage') {

			$query = ''; // EMPTY QUERY

			if (isset($_GET['page']) && $_GET['page'] == 'Pending' ) { // SHOW Pending Users From users Page using If Condition
				$query = 'AND RegStatus =0';
			}

			$stmt = $con->prepare("SELECT * FROM users WHERE GroupeID != 1 $query"); // Select all Users Expect Administrators
			$stmt->execute(); // Execute the statement
			$rows = $stmt->fetchAll(); // Fetch all data

			if(!empty($rows)) {

		?>
			<!-- HEADING OF THE PAGE -->
			<div class="ehead"> <h1 class="text-center">Users Manage Page</h1></div>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table text-center table table-bordered">
						<tr>
							<td>#ID</td>
							<td>Username</td>
							<td>Email</td>
							<td>Full name</td>
							<td>Registred date</td>
							<td>Control</td>
						</tr>

						<?php

						foreach($rows as $row) {

							echo "<tr>"; // START TAbLE ROW
								echo "<td>" . $row['UserID'] . "</td>";
								echo "<td>" . $row['Username'] . "</td>";
								echo "<td>" . $row['Email'] . "</td>";
								echo "<td>" . $row['FullName'] . "</td>";
								echo "<td>" . $row['Date'] . "</td>";
								
								echo "<td>";
									echo "<a href='?do=Edit&userid=" . $row['UserID'] . "'" . "class='btn btn-success'>";
									echo "<i class='fa fa-edit'></i>Edit</a> ";

									echo "<a href='?do=Delete&userid=" . $row['UserID'] . "'" . "class='btn btn-danger confirm'>";
									echo "<i class='fa fa-close'></i>Delete</a> ";

									echo "<a href='profile.php?userid=" . $row['UserID'] . "'" . "class='btn btn-info'>";
									echo "<i class='fa fa-eye'></i>View</a> ";

								// Case User is Not Activated yet ==> show Btn of Activation
								if ($row['RegStatus'] == 0) {
									echo "<a href='?do=Activate&userid=" . $row['UserID'] . "'" . "class='btn btn-info activate'><i class='fa fa-check'></i>activate</a>";
								}
								
								echo "</td>";

							echo "</tr>"; // END TAbLE ROW
						}

						?>

					</table>
				</div>
				<a class="btn btn-sm btn-primary" href="?do=Add"><i class='fa fa-plus'></i> new user</a>
			</div>
		<?php } else {

			echo '<div class="container">';
				$theMsg = "<div class='alert alert-info'> There is no users</div>";
				redirectHome($theMsg, 'index.php', 2);
			echo '</div>';

		} ?>
		<?php
		
		/*
		========================
		|  ADD NEW USER PAGE   |
		========================
		*/

		} elseif ($do == 'Add') { ?>

			<!-- STRUCTURE OF THE PAGE -->

			<div class="ehead"> <h1 class="text-center">Add Users Page</h1></div> <!-- Heading -->
			
			<div class=container >
				<form class="form-horizontal" action="?do=Insert" method="POST">

				<!-- Start username field -->

					<div class="form-group">
						<label class="col-sm-2 control-label">Username</label>
						<div class="col-sm-10 col-md-4">
						<input type="text" name="username" class="form-control" autocomplete = "off" required="required" placeholder="your username">
						</div>
					</div>

				<!-- Start password field -->

					<div class="form-group">
						<label class="col-sm-2 control-label">Password</label>
						<div class="col-sm-10 col-md-4">
						<input type="password" name="password" class="password form-control" autocomplete = "new-password" required="required" placeholder="your password">
						<i class="show-pass fa fa-eye"></i>
						</div>
					</div>

				<!-- Start Email field -->

					<div class="form-group">
						<label class="col-sm-2 control-label">Email</label>
						<div class="col-sm-10 col-md-4">
						<input type="text" name="email" class="form-control" required="required" placeholder="name@example.com">
						</div>
					</div>

				<!-- Start FullName field -->

					<div class="form-group">
						<label class="col-sm-2 control-label">Full Name</label>
						<div class="col-sm-10 col-md-4">
						<input type="text" name="fullname" class="form-control" required="required" placeholder="your full name">
						</div>
					</div>
				<!-- Start Image field -->	
					<div class="form-group">
						<label class="col-sm-2 control-label">Image link</label>
						<div class="col-sm-10 col-md-4">
						<input type="text" name="img" class="form-control" required="required" placeholder="Image Link">
						</div>
					</div>
				<!-- Start RegStatus field -->	

					<div class="form-group">
						<label class="col-sm-2 control-label">Status</label>
						<div class="col-sm-10 col-md-4">
						<input type="text" name="regstatus" class="form-control" required="required" placeholder="0 or 1">
						</div>
					</div>

				<!-- Start button field -->

					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
						<input type="submit" value="Add user" class="btn btn-info">
						</div>
					</div>
				</form>
			</div>
		<?php

		/*
		=======================
		| INSERT USERS PAGE   |
		=======================
		*/

		} elseif ($do == 'Insert') { // INSERT PAGE 

			// HEADING OF THE PAGE

			echo '<div class="ehead"> <h1 class="text-center">Insert Page</h1></div>';
			echo '<div class="container">';
				
			// Check if the User Access From a POST REQUEST

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				
				// Get Datas from the FORM AND Store it;

				$user = $_POST['username'];
				$pass = $_POST['password'];
				$email = $_POST['email'];
				$full = $_POST['fullname'];
				$img = $_POST['img'];
				$reg = $_POST['regstatus']; // RegStatus


				$hashPass = sha1($pass);

				// Validate the Form

				$formErrors = array();

				if (strlen($user) < 4) {
					$formErrors[] = 'Username cant contain less than <strong>4 character</strong>';
				}

				if (empty($user)) {
					$formErrors[] = 'Username can\'t be <strong>empty</strong>';
				}

				if (empty($email)) {
					$formErrors[] = 'Email can\'t be <strong>empty</strong>';
				}

				if (empty($full)) {
					$formErrors[] = 'Full name can\'t be <strong>empty</strong>';
				}

				foreach($formErrors as $error) {
					echo '<div class="alert alert-danger">' . $error ."</div>";
				}

				// Check if there is no error = $formErrors Array empty !

				if (empty($formErrors)) {

					// Check If the User exist in Database

					$check = checkItem("Username","users", $user);

					if ($check != 1 ) {

						// Insert New User into database

						$stmt = $con->prepare("INSERT INTO users(Username, Password, Email, FullName, Image, RegStatus, Date)
												VALUES(:zuser, :zpass, :zemail, :zname, :zimg, :zreg, now())");
						$stmt->execute(array(

							'zuser'  => $user,
							'zpass'  => $hashPass,
							'zemail' => $email,
							'zname'  => $full,
							'zimg'   => $img,
							'zreg'   => $reg

						));

						// Echo Sucess message with the number of records
						$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Records inserted' . '</div>';
						redirectHome($theMsg, 'users.php', 2);

					} else {
						$theMsg = "<div class='alert alert-danger'> $user already registered, try another username</div>";
						redirectHome($theMsg, 'back', 2);
					}

				}

			echo '</div>';

			} else {
				echo '<div class="container">';
				$theMsg = "<div class='alert alert-danger'>Sorry you can't browse this page directyl</div>";
				redirectHome($theMsg);
				echo '</div>';

			}

		/*
		=======================
		| EDIT USERS PAGE   |
		=======================
		*/

		} elseif ($do == 'Edit') {

			// Check if GET Request userid is numeric and get the integer value of it
			$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

			// ~Select all data depend on this ID
			$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");

			// ~Execute the query
			$stmt->execute(array($userid));

			// Fetch the Data
			$row = $stmt->fetch();

			// If there's such ID show the form
			$count = $stmt->rowCount();

			if ($count > 0 ) { ?>
			
				<div class="ehead">
					<h1 class="text-center">Edit Users Page</h1>
				</div>
				<div class="container">
					<!-- Start username field -->
					<form class="form-horizontal" action="?do=Update" method="POST">

						<input type="text" class="hidden" name="userid" value="<?php echo $userid ?>">

						<div class="form-group">
							<label class="col-sm-2 control-label">Username</label>
							<div class="col-sm-10 col-md-4">
							<input type="text" name="username" class="form-control" autocomplete = "off" value="<?php echo $row['Username']?>" required="required">
							</div>
						</div>
					<!-- Start password field -->
						<div class="form-group">
							<label class="col-sm-2 control-label">Password</label>
							<div class="col-sm-10 col-md-4">
							<input class="hidden" type="text" name="oldpassword" value="<?php echo $row['Password']?>">
							<input type="password" name="newpassword" class="form-control" autocomplete = "new-password" placeholder="Leave it empty for default password">
							</div>
						</div>
					<!-- Start Email field -->
						<div class="form-group">
							<label class="col-sm-2 control-label">Email</label>
							<div class="col-sm-10 col-md-4">
							<input type="text" name="email" class="form-control" value="<?php echo $row['Email']?>" required="required">
							</div>
						</div>
					<!-- Start FullName field -->
						<div class="form-group">
							<label class="col-sm-2 control-label">Full Name</label>
							<div class="col-sm-10 col-md-4">
							<input type="text" name="fullname" class="form-control" value="<?php echo $row['FullName']?>" required="required">
							</div>
						</div>
					<!-- Start Image field -->	
						<div class="form-group">
							<label class="col-sm-2 control-label">Image link</label>
							<div class="col-sm-10 col-md-4">
							<input type="text" name="img" class="form-control" value="<?php echo $row['Image']?>" required="required">
							</div>
						</div>
					<!-- Start RegStatus field -->	

						<div class="form-group">
							<label class="col-sm-2 control-label">Status</label>
							<div class="col-sm-10 col-md-4">
							<select name="regstatus">
								<option value="1" <?php if ($row['RegStatus'] == 1) { echo 'selected';} ?>>Activated</option>
								<option value="0" <?php if ($row['RegStatus'] == 0) { echo 'selected';} ?>>Appended</option>
							</select>
							</div>
						</div>
					<!-- Start button field -->
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" value="update" class="btn btn-primary">
							</div>
						</div>
					</form>
				</div>		
			<?php } else { // ~ Show Error Message ~ No Id Found ~
				echo '<div class="container">';
				$theMsg = "<div class='alert alert-danger'>no user found to edit</div>";
				redirectHome($theMsg);
				echo '</div>';
			}

		/*
		=======================
		| UPDATE USERS PAGE   |
		=======================
		*/

		} elseif($do == 'Update') {

			echo '<div class="ehead"> <h1 class="text-center">Update Users Page</h1></div>';
			echo '<div class="container">';
			echo '<div class="col-md-6">';

			// ~ Check if the user come form a POST Request or directly ?
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				// Get variables from the FORM
				$id = $_POST['userid'];
				$user = $_POST['username'];
				$email = $_POST['email'];
				$full = $_POST['fullname'];
				$img = $_POST['img'];
				$reg = $_POST['regstatus'];
				// ~ Password Trick
				$pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);

				// ~ Validate the Form
				$formErrors = array();

				if (strlen($user) < 4) {
					$formErrors[] = 'Username cant contain less than <strong>4 character</strong>';
				}

				if (empty($user)) {
					$formErrors[] = 'Username can\'t be <strong>empty</strong>';
				}

				if (empty($email)) {
					$formErrors[] = 'Email can\'t be <strong>empty</strong>';
				}

				if (empty($full)) {
					$formErrors[] = 'Full name can\'t be <strong>empty</strong>';
				}

				foreach($formErrors as $error) {
					echo '<div class="alert alert-danger">' . $error ."</div>";
				}

				// Check if there is no error ?
				if (empty($formErrors)) {

					//~ UPDATE the database with thos info
					$stmt = $con->prepare("UPDATE users SET Username = ?, Email = ?, FullName = ?, Password = ?, Image = ?, RegStatus = ? WHERE UserID = ?");
					$stmt->execute(array($user, $email, $full, $pass, $img, $reg, $id));

					// Echo Sucess message with the number of records
					$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Records updated' . '</div>';
					redirectHome($theMsg, 'users.php',2);

				}
				
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

			echo '<div class="ehead"> <h1 class="text-center">Delete Users Page</h1></div>';
			echo '<div class="container">';

			// ~Check if GET Request userid is numeric and get the integer value of it
			$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

			// ~Select all data depend on this ID
			$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");

			// ~Execute the query
			$stmt->execute(array($userid));

			// If there's such ID DELETE the User
			$count = $stmt->rowCount();

			if ($count > 0 ) {
				
				$stmt  = $con->prepare("DELETE FROM users WHERE UserID = :zuser");
				$stmt->bindParam(":zuser", $userid);
				$stmt->execute();

				// Echo Sucess message with the number of records
				
				$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Records deleted' . '</div>';
				redirectHome($theMsg,'back',2);

			} else {
				$theMsg = '<div class="alert alert-success">User not found!</div>';
				redirectHome($theMsg, 'users.php',4);
			}

			echo '</div>';

		/*
		==========================
		|  ACTIVATE USERS PAGE   |
		=========================
		*/


		} elseif($do == 'Activate') {
			// Activate Users Page
			echo '<div class="ehead"> <h1 class="text-center">Delete Users Page</h1></div>';
			echo '<div class="container">';

			$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

			$check = checkItem('UserID', 'users', $userid);

			if ($check > 0 ) {
				
				$stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID = ?");
				$stmt->execute(array($userid));

				// Echo Sucess message with the number of records
				$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Records Activated' . '</div>';
				redirectHome($theMsg,'back',2);

			} else {
				$theMsg = '<div class="alert alert-success">User not found!</div>';
				redirectHome($theMsg, 'users.php',4);
			}

			echo '</div>';
		}	

		include $tpl . 'footer.php';

	} else {

		header('Location: index.php');
		exit();

	}


ob_end_flush(); // Sent Outpute After Storing It