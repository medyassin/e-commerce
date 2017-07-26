<?php
	/*
	==============================================================
	==> Dashboard page
	==============================================================
	*/
	session_start();

	if(isset($_SESSION['Username'])) { // Check if the user is logged in

		include 'init.php';
		
		if (isset($_GET['userid'])) {

			$userid = $_GET['userid']; // Store userid into variable

			$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ?");
			$stmt->execute(array($userid));

			$row = $stmt->fetch(); // Get User From Database ?>


		<!-- START PROFILE PAGE STRUCTURE -->

		<div class="profile">
			<div class="overlay">
				<div class="container">
					<div class="col-md-2">
						<div class="img">
							<img src="
							<?php
							if (isset($row['Image'])) {
								echo $row['Image']; 
							} else {
								echo 'data/uploads/me.png';
							}

							?> 
							" alt="img-profile">
						</div>
					</div>
					<div class="col-md-10">
						<div class="info">
							<h3><?php echo $row['FullName']; ?></h3>
							<p><?php echo "@" . $row['Username']; ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- END PROFILE PAGE STRUCTURE -->

		<?php
			
		include $tpl . 'footer.php';

		} else {

			header('Location: index.php');
		}

	}

?>