<?php
	session_start();
	$nonNavBar = '';
	$pageTitle = 'Login Page';
	if (isset($_SESSION['Username'])) {
		header('Location: dashboard.php');
	}

	include 'init.php'; // Include initialize file

	if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Check if User Coming From HTTP POST Request
		$username   = $_POST['user'];
		$password   = $_POST['pass'];
		$hashedPass = sha1($password);

		// Check If The User Exist in Database
		$stmt = $con->prepare("SELECT
									 UserID, Username, Password 
								FROM users 
								WHERE Username = ? 
								AND 
									Password = ? 
								AND 
									GroupeID = 1
								LIMIT 1");
		$stmt->execute(array($username, $hashedPass));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();

		// If count > 0 means that the database contain the records about the User
		if ($count > 0) {
			$_SESSION['Username'] = $username; // Registre session username
			$_SESSION['ID'] = $row['UserID'];  // Registre session ID
			header('Location: dashboard.php');
			exit();
		} else {
			echo '<div class="alert alert-danger">this page is for administrators</div>';
		}
	}

?>
	<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method = "POST">
		<h4 class="text-center"><span class="icon-l"><i class="fa fa-user-circle-o"></i></span>Sign in to eCommerce</h4>
		<div class="login-git">
			<label for="user">user name</label>
			<input class="form-control" type="text" id="user" name="user" placeholder="Username" autocomplete="off">
			<label for="pass">password</label>
			<input class="form-control" type="password" id="pass" name="pass" placeholder="password" autocomplete="new-password">
			<input class="login-btn btn btn-primary btn-block" type="submit" value="Log in">
		</div>
		<div class="new-account text-center">
			New on eCommerce <span><a href="signup.php">Create an account ?</a></span>
		</div>
	</form>
<?php include $tpl . 'footer.php' ?>