<?php
	ob_start();
	session_start();
	$pageTitle = $_SESSION['user'] . ' - Profile';
	include 'init.php';

	if(isset($_SESSION['user'])) { 

	$getUser = $con->prepare("SELECT * FROM users WHERE Username = ?");
	$getUser->execute(array($sessionUser));

	$info = $getUser->fetch();

	?>
	<!-- Start Page Heading -->
	<div class="container">
		<h1><?php echo $sessionUser . ' - Profile' ?></h1>
	</div>
	<!-- End Page Heading -->

	<!-- Start Profile Information -->
	<div class="information block">
		<div class="container">
			<div class="panel panel-default">
				<div class="panel-heading">
					My Information
				</div>
				<div class="panel-body">
					<ul class="list-unstyled">
						<li>
							<i class="fa fa-unlock-alt fa-fw"></i>
							<span>Name:</span> <?php echo $info['Username'] ?>
						</li>
						<li>
							<i class="fa fa-envelope-o fa-fw"></i>
							<span>E-Mail:</span> <?php echo $info['Email'] ?>
						</li>
						<li>
							<i class="fa fa-user fa-fw"></i>
							<span>Full Name:</span> <?php echo $info['FullName'] ?>
						</li>
						<li>
							<i class="fa fa-calendar fa-fw"></i>
							<span>Register Date:</span> <?php echo $info['Date'] ?>
						</ll>
						<li>
							<i class="fa fa-tags fa-fw"></i>
							<span>Favorite Category:</span>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!-- End Profile Information -->

	<!-- Start Profile Items -->
	<div class="my-items items block">
		<div class="container">
			<div class="panel panel-default">
				<div class="panel-heading">
					My Items
				</div>
				<div class="panel-body">
					<?php
						$items = getItem('User_ID', $info['UserID']);

						if (! empty($items)) {
							foreach($items as $item) {

								// replace status by strings
								switch($item['Status']) {
									case 1:
										$itemS = 'New';
										break;
									case 2:
										$itemS = 'Like New';
										break;
									case 3:
										$itemS = 'Used';
										break;
									default:
										$itemS = 'Very Old';
								}

								echo '<div class="col-sm-4 col-md-3">';
									echo '<div class="item-box">';
										echo '<span class="status">' . $itemS . '</span>';
										echo '<a href="item.php?itemid=' . $item['Item_ID'] . '"><img src="data/uploads/items/' . $item['Image'] . '" alt="item-image"></a>';
										echo '<span class="user">' . $item['user_name'] . '</span>';
										echo '<span class="title">' . $item['Name'] . '</span>';
										echo '<span class="price">' . $item['Price'] . ' dhs' . '</span>';
									echo '</div>';
								echo '</div>';
							}
						} else {
							echo 'there is no items to show, Create <a href="newitem.php"> New Item</a>' ;
						}
					?>
				</div>
			</div>
		</div>
	</div>

	<!-- End Profile Items -->

	<!-- Start Profile Items -->
	<div class="my-comments block">
		<div class="container">
			<div class="panel panel-default">
				<div class="panel-heading">
					Latest Comments
				</div>
				<div class="panel-body">
					<?php
						$stmt = $con->prepare("SELECT comments.c FROM comments WHERE c_user_id = ?");
						$stmt->execute(array($info['UserID'])); // Execute the statement
						$comments = $stmt->fetchAll(); // Fetch all data

						if( ! empty($comments)) {
							foreach($comments as $comment) {
								echo '<p>' . $comment['c'] . '</p>';
							}
						} else {
							echo 'there is no comment to show';
						}
					?>
				</div>
			</div>
		</div>
	</div>

	<!-- End Profile Items -->

	<?php } else {
		header('Location: login.php');
	}

	include $tpl . 'footer.php';
	ob_end_flush();
?>