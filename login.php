<?php
	ob_start();
	session_start();
	$pageTitle = 'Login Page';
	if (isset($_SESSION['user'])) {
		header('Location: index.php');
	}

	include 'init.php'; // Include initialize file

	if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Check if User Coming From HTTP POST Request

		if (isset($_POST['signin'])) {
			$user   = $_POST['username'];
			$pass   = $_POST['password'];
			$hashedPass = sha1($pass);

			// Check If The User Exist in Database
			$stmt = $con->prepare("SELECT
										UserID, Username, Password 
									FROM users 
									WHERE Username = ? 
									AND 
										Password = ?");

			$stmt->execute(array($user, $hashedPass));
			$get = $stmt->fetch();
			$count = $stmt->rowCount();

			// If count > 0 means that the database contain the records about the User
			if ($count > 0) {
				$_SESSION['user'] = $user; // Registre session username
				$_SESSION['uid'] = $get['UserID']; // Registre User ID in Session

				header('Location: index.php');
				exit();
			}
		} else {

			$formErrors = array();


			// Get Image Info From the Form And Store it:

			$imgName = $_FILES['image']['name'];
			$imgSize = $_FILES['image']['size'];
			$imgTmp  = $_FILES['image']['tmp_name'];
			$imgType = $_FILES['image']['type'];
			
			$imgAllowedExt  = array("jpeg", "jpg", "png", "gif");

			// Get Image Extension

			$imgExtArr = explode('.', $imgName);
			$imgExt = strtolower(end($imgExtArr));

			$username = $_POST['username']; 
			$password = $_POST['password'];	
			$password2 = $_POST['password2']; 
			$email = $_POST['email'];
			// Check Usernamne

			if (isset($username)) {
				$filteredUser = filter_var($username, FILTER_SANITIZE_STRING);

				if(strlen($filteredUser) < 4) {
					$formErrors[] = 'Username must be larger than 4 character';
				}
			}

			// Check Password

			if (isset($password) && isset($password2)) {

				if(empty($password)) {
					$formErrors[] = 'Password can\'t be emty!';
				}

				if (sha1($password) !== sha1($password2)) {
					$formErrors[] = 'Password doesn\'t match';
				}
			}

			// Check Email

			if (isset($email)) {

				$filteredEmail = filter_var($email, FILTER_SANITIZE_EMAIL);

				if (filter_var($filteredEmail, FILTER_VALIDATE_EMAIL) != true) {
					$formErrors[] = 'This email is not valid';
				}
			}

			if (empty($formErrors)) {

				$image = rand(0,1000000) . '_' . $imgName;

				move_uploaded_file($imgTmp, 'C:\XAMPP\htdocs\eCommerce\data\uploads\\' . $image);

				// Check If the User exist in Database

				$check = checkItem("Username","users", $username);

				if ($check != 1 ) {

					// Insert New User into database

					$stmt = $con->prepare("INSERT INTO users(Username, Password, Email, Image, RegStatus, Date)
											VALUES(:zuser, :zpass, :zemail, :zimg, 0, now())");
					$stmt->execute(array(

						'zuser'  => $username,
						'zpass'  => sha1($password),
						'zemail' => $email,
						'zimg'	 => $image
					));

					// Echo Sucess message with the number of records
					$sucessMsg = 'Congrat, your are now registered user';

				} else {
					$formErrors[] = 'Sorry, This user exists !';
				}
			}
		}
	}
?>

<div class="container login-page">
	<h1 class="text-center">
		<span class="selected" data-class="login">Login</span> | 
		<span data-class="signup">Signup</span>
	</h1>
	<!-- Start Login Form -->
	<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
		<div class="input-container">
			<input 
				class="form-control" 
				type="text" 
				name="username" 
				autocomplete="off"
				placeholder="Type your username" 
				required />
		</div>
		<div class="input-container">
			<input
				class="form-control" 
				type="password" 
				name="password" 
				autocomplete="new-password"
				placeholder="Type your password" 
				required />
		</div>
		<input class="btn btn-primary btn-block" name="signin" type="submit" value="Login" />
	</form>
	<!-- End Login Form -->
	<!-- Start Signup Form -->
	<form class="signup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
		<div class="input-container">
			<input
				pattern = ".{4,}"
				title = "Username Must be 4 chars"
				class="form-control" 
				type="text" 
				name="username" 
				autocomplete="off"
				placeholder="Type your username" 
				required />
		</div>
		<div class="input-container">
			<input 
				minlength="4"
				class="form-control" 
				type="password" 
				name="password" 
				autocomplete="new-password"
				placeholder="Type a Complex password" 
				required />
		</div>

		<div class="input-container">
			<input 
				minlength="4"
				class="form-control" 
				type="password" 
				name="password2" 
				autocomplete="new-password"
				placeholder="Type a password again" 
				 />
		</div>

		<div class="input-container">
			<input 
				class="form-control" 
				type="email" 
				name="email" 
				placeholder="Type a Valid email"
				required />
		</div>

		<div class="input-container">
			<input 
				class="form-control" 
				type="file" 
				name="image"
				required />
		</div>
		<input class="btn btn-success btn-block" name="signup" type="submit" value="Signup" />


	</form>
	<!-- End Signup Form -->

	<div class="the-errors text-center">
		<?php 
			if (! empty($formErrors)) {
				foreach($formErrors as $error) {
					echo '<div class="msg error">' . $error . '</div>';
				}
			}

			if (isset($sucessMsg)) {
				echo '<div class="msg success">' . $sucessMsg . '</div>';
			}
		?>
	</div>

</div>

<?php
	include $tpl . 'footer.php';
	ob_end_flush();


