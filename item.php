<?php
	ob_start();
	session_start();
	$pageTitle = 'Item View';
	include 'init.php';

	// Check if GET Request itemid is numeric and get the integer value of it
	$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

	// ~Select all data depend on this ID
	$stmt = $con->prepare("
						SELECT items.*, cats.Name AS cat_name, users.Username
						FROM items 
						INNER JOIN cats ON cats.ID = items.Cat_ID

						INNER JOIN users ON users.UserID = items.User_ID 

						WHERE Item_ID = ?");

	// ~Execute the query
	$stmt->execute(array($itemid));

	// Fetch the Data
	$item = $stmt->fetch();

	// If there's such ID show the form
	$count = $stmt->rowCount();

	if ($count > 0) { ?>

		<div class="container show-item">
			<h1>Show Item</h1>

			<!-- Start Item Infomarion -->
			<div class="row">
				<div class="col-md-4">
					<div class="show-img">
						<img src="data/uploads/items/<?php echo $item['Image'] ?>" alt="">
						<div class="show-status">
						<?php echo getStatus($item['Status']) ?>
						</div>
					</div>
				</div>
				<div class="col-md-8">
					<div class="show-meta">
						<span><i class="fa fa-file-o"></i> <?php echo $item['Add_Date'] ?></span>  <!-- Added Date -->

						<span> <!-- Category Name -->
							<a href="cats.php?catid=<?php echo $item['Cat_ID'] . '&name=' . strtolower(str_replace(' ', '-',$item['cat_name'])) ?>">
								<i class="fa fa-bookmark-o"></i> <?php echo $item['cat_name'] ?>
							</a>
						</span>

						<span><i class="fa fa-bell-o"></i> Made In: <?php echo $item['Country_Made'] ?></span> <!-- Country Made -->

						<span class="show-user"><i class="fa fa-user-o"></i> <a href="#"><?php echo $item['Username'] ?></a></span> <!-- User Name -->
					</div>

					<h3 class="show-title"><?php echo $item['Name'] ?></h3>
					<div class="show-desc">
						<h4>Description</h4>
						<p><?php echo $item['Description'] ?></p>
					</div>

					<div class="show-price">
						<span><?php echo $item['Price'] . ' dhs' ?></span>
						<button>J'achète!</button>	
					</div>
				</div>
			</div>

			<!-- End Item Infomarion -->

			<hr>
			
			<!-- Start Add comment -->

			<div class="row">
				<div class="col-md-offset-4 col-md-8">
					<div class="add-comment">
						<h3>Ajouter Un commentaire</h3>
						<?php if (isset($_SESSION['user'])) {
							echo '<form action="' . $_SERVER['REQUEST_URI'] . '" method="POST" >';
								echo '<textarea name="comment" placeholder="Write your comment"></textarea>';
								echo '<input type="submit">';
							echo '</form>';
						} else {
							echo '<div class="alert alert-custom">you are not logged in to comment: <a href="login.php">log in</a> or <a href="login.php"Registre">Registre</a></div>';
						}

						?>
					</div>
					<?php
						if($_SERVER['REQUEST_METHOD'] == 'POST') {
							echo 'your comment: ' . $_POST['comment'];
							echo '<div class="alert alert-success">your comment has been added successfuly</div>';
						} 
					?>
				</div>
			</div>

			<!-- End Add Comment -->

			<hr>

			<!-- Start Item Comments -->
			<div class="col-md-2">
			User Image
			</div>

			<div class="col-md-8">
			User Comment
			</div>
			<!-- End Item Comments -->
		</div>








<?php
	} else {
		echo '<div class="container">';
			$theMsg = '<div class="alert alert-info">There is no items to show</div>';
			redirectHome($theMsg, 'index.php');
		echo '</div>';
	}
?>

<?php
	include $tpl . 'footer.php';
	ob_end_flush();
?>