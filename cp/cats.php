<?php

	/*
	==================================================
	==> Categorie Page
	==================================================
	*/

	ob_start();
	session_start();

	$pageTitle = 'Categories';

	if(isset($_SESSION['Username'])) {

		// PAGE CONTENT

		include 'init.php';

		// DIVIDE PAGE 
		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
		/*
		=======================
		| MANAGE CATS PAGE    |
		=======================
		*/

		if ($do == 'Manage') {


			$orderSelctor = 'Ordering';

			$sort = 'DESC';

			$sort_array = array('ASC', 'DESC');

			$selctor_array = array('ID', 'Ordering');

			if(isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)) {
				$sort = $_GET['sort'];
				if (isset($_GET['Order']) && in_array($_GET['Order'], $selctor_array)) {
					$orderSelctor = $_GET['Order'];
				}
			}

			echo '<div class="ehead"> <h1 class="text-center">Manage Categories</h1></div>';
			echo '<div class="container categories">';

			$stmt2 = $con->prepare("SELECT * FROM cats ORDER BY $orderSelctor $sort");
			$stmt2->execute();
			$cats = $stmt2->fetchAll(); 

			if(! empty($cats)) { ?>

			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-gear"></i><span class="panel-h"> Manage Categories</span>
					<div class="ordering pull-right">
					Ordering
					<a class="<?php if ($sort == 'ASC' && $orderSelctor == 'Ordering') {echo 'active-order';} ?>" href="?sort=ASC&Order=Ordering"><i class="fa fa-sort-amount-desc"></i></a> 
					<a class="<?php if ($sort == 'DESC' && $orderSelctor == 'Ordering') {echo 'active-order';} ?>" href="?sort=DESC&Order=Ordering"><i class="fa fa-sort-amount-asc"></i></a>
					<a class="<?php if ($sort == 'ASC' && $orderSelctor == 'ID') {echo 'active-order';} ?>" href="?sort=ASC&Order=ID"><i class="fa fa-sort-numeric-asc"></i></a>
					<a class="<?php if ($sort == 'DESC' && $orderSelctor == 'ID') {echo 'active-order';} ?>" href="?sort=DESC&Order=ID"><i class="fa fa-sort-numeric-desc"></i></a>
					View
					<span class="full"><i class="fa fa-bars"></i></span>
					<span class="classic active-order"><i class="fa fa-ellipsis-h"></i></span>
					</div>
				</div>
				<div class="panel-body">
				<?php
					foreach($cats as $cat) {
						echo "<div class='cat'>";
							echo "<div class='hidden-btns'>";
								echo "<a href='?do=Edit&catid=". $cat['ID'] ."' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i> Edit</a>";
								echo "<a href='?do=Delete&catid=" . $cat['ID'] . "' class='btn btn-xs btn-danger'><i class='fa fa-close'></i> Delete</a>";
							echo "</div>";
							echo "<h3>" . $cat['Name'] . "</h3>";
							echo "<div class='full-view'>";
								echo "<p>"; if($cat['Description'] == '') { echo 'this categorie has no description';
								} else {echo $cat['Description'];} echo "</p>";
								if ($cat['Visibility'] == 1) {echo '<span class="visibility globalspan">Hidden</span>';};
								if ($cat['AllowComment'] == 1) {echo '<span class="commenting globalspan">Comment Disabled</span>';}
								if ($cat['AllowAds'] == 1) {echo '<span class="ads globalspan">Ads Disabled</span>';}
							echo '</div>';


						echo '</div>';
					}

				?>
				</div>
			</div>

			<?php } else {
				echo '<div class="container">';
					echo "<div class='alert alert-info'> There is no categories to show</div>";
				echo '</div>';
				} 
			?>
				<div class="container">
					<a class="btn btn-sm btn-primary" href="?do=Add"><i class="fa fa-plus"></i> new category</a>
				</div>
			<?php
		/*
		=======================
		| ADD CATS PAGE       |
		=======================
		*/
		
		} elseif ($do == 'Add') { ?>

			<!-- Heading of the Page -->

			<div class="ehead"> <h1 class="text-center">Add Categories Page</h1></div>

			<!-- STRUCTURE OF THE PAGE -->
			
			<div class=container >
				<form class="form-horizontal" action="?do=Insert" method="POST">

				<!-- Start Name field -->

					<div class="form-group">
						<label class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10 col-md-4">
						<input type="text" name="name" class="form-control" autocomplete = "off" required="required" placeholder="Categorie Name">
						</div>
					</div>

				<!-- Start Description field -->

					<div class="form-group">
						<label class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10 col-md-4">
						<input type="text" name="description" class="form-control"  placeholder="Categorie Description">
						</div>
					</div>

				<!-- Start Ordering field -->

					<div class="form-group">
						<label class="col-sm-2 control-label">Ordering</label>
						<div class="col-sm-10 col-md-4">
						<input type="text" name="ordering" class="form-control" placeholder="Ordre of the categorie">
						</div>
					</div>

				<!-- Start Visibility field -->

					<div class="form-group">
						<label class="col-sm-2 control-label">visible</label>
						<div class="col-sm-10 col-md-4">
							<div>
								<input id="vis-yes" type="radio" name="visibility" value="0" checked="checked">
								<label for="vis-yes">yes</label>
							</div>
							<div>
								<input id="vis-no" type="radio" name="visibility" value="1">
								<label for="vis-no">No</label>
							</div>
						</div>
					</div>

				<!-- Start Comments field -->

					<div class="form-group">
						<label class="col-sm-2 control-label">Allow Comments</label>
						<div class="col-sm-10 col-md-4">
							<div>
								<input id="com-yes" type="radio" name="comments" value="0" checked="checked">
								<label for="com-yes">enable</label>
							</div>
							<div>
								<input id="com-no" type="radio" name="comments" value="1">
								<label for="com-no">disable</label>
							</div>
						</div>
					</div>
				<!-- Start Ads field -->

					<div class="form-group">
						<label class="col-sm-2 control-label">Allow Ads</label>
						<div class="col-sm-10 col-md-4">
							<div>
								<input id="ads-yes" type="radio" name="ads" value="0" checked="checked">
								<label for="ads-yes">enable</label>
							</div>
							<div>
								<input id="ads-no" type="radio" name="ads" value="1">
								<label for="ads-no">disable</label>
							</div>
						</div>
					</div>

				<!-- Start button field -->

					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
						<input type="submit" value="Add Category" class="btn btn-info">
						</div>
					</div>
				</form>
			</div>

		<?php

		/*
		=======================
		| INSERT CATS PAGE    |
		=======================
		*/

		} elseif ($do == 'Insert') { // INSERT PAGE 

			// HEADING OF THE PAGE

			echo '<div class="ehead"> <h1 class="text-center">Insert Page</h1></div>';
			echo '<div class="container">';
				
			// Check if the User Access From a POST REQUEST

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				
				// Get Datas from the FORM AND Store it;

				$name = $_POST['name'];
				$desc = $_POST['description'];
				$ordering = $_POST['ordering'];
				$vis = $_POST['visibility'];
				$comm = $_POST['comments']; 
				$ads = $_POST['ads']; 


				// Validate the Form

				// Check if there is no error = $formErrors Array empty !

				if (true) {

					// Check If the User exist in Database


					$check = checkItem("name","cats", $name);

					if ($check != 1 ) {

						// Insert New User into database

						$stmt = $con->prepare("INSERT INTO cats(Name, Description, Ordering, Visibility, AllowComment,AllowAds) VALUES(?,?,?,?,?,?)");
						$stmt->execute(array($name, $desc, $ordering, $vis, $comm, $ads));

						// Echo Sucess message with the number of records
						$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Records inserted' . '</div>';
						redirectHome($theMsg, 'cats.php', 2);

					} else {
						$theMsg = "<div class='alert alert-danger'> $name already registered, try another username</div>";
						redirectHome($theMsg, 'back', 200);
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
		==========================
		| EDIT CATEGORIES PAGE   |
		=========================
		*/

		} elseif ($do == 'Edit') {

			// Check if GET Request catid is numeric and get the integer value of it
			$catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

			// ~Select all data depend on this ID
			$stmt3 = $con->prepare("SELECT * FROM cats WHERE ID = ? LIMIT 1");

			// ~Execute the query
			$stmt3->execute(array($catid));

			// Fetch the Data
			$row = $stmt3->fetch();

			// If there's such ID show the form
			$count = $stmt3->rowCount();
			
			if ($count > 0 ) { ?>


			<!-- Heading of the Page -->

			<div class="ehead"> <h1 class="text-center">Edit Categories Page</h1></div>

			
			<div class=container >
				<form class="form-horizontal" action="?do=Update" method="POST">

				<!-- Start Name field -->
					<input type="text" class="hidden" name="id" value="<?php echo $row['ID'] ?>">
					<div class="form-group">
						<label class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10 col-md-4">
						<input type="text" name="name" class="form-control" autocomplete = "off" required="required" value="<?php echo $row['Name']?>">
						</div>
					</div>

				<!-- Start Description field -->

					<div class="form-group">
						<label class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10 col-md-4">
						<input type="text" name="description" class="form-control" value="<?php echo $row['Description']?>">
						</div>
					</div>

				<!-- Start Ordering field -->

					<div class="form-group">
						<label class="col-sm-2 control-label">Ordering</label>
						<div class="col-sm-10 col-md-4">
						<input type="text" name="ordering" class="form-control" value="<?php echo $row['Ordering']?>">
						</div>
					</div>

				<!-- Start Visibility field -->

					<div class="form-group">
						<label class="col-sm-2 control-label">visible</label>
						<div class="col-sm-10 col-md-4">
							<div>
								<input id="vis-yes" type="radio" name="visibility" value="0" <?php if ($row['Visibility'] == 0) {echo 'checked';}?>>
								<label for="vis-yes">yes</label>
							</div>
							<div>
								<input id="vis-no" type="radio" name="visibility" value="1" <?php if ($row['Visibility'] == 1) {echo 'checked';}?>>
								<label for="vis-no">No</label>
							</div>
						</div>
					</div>

				<!-- Start Comments field -->

					<div class="form-group">
						<label class="col-sm-2 control-label">Allow Comments</label>
						<div class="col-sm-10 col-md-4">
							<div>
								<input id="com-yes" type="radio" name="comments" value="0" <?php if ($row['AllowComment'] == 0) {echo 'checked';}?>>
								<label for="com-yes">enable</label>
							</div>
							<div>
								<input id="com-no" type="radio" name="comments" value="1" <?php if ($row['AllowComment'] == 1) {echo 'checked';}?>>
								<label for="com-no">disable</label>
							</div>
						</div>
					</div>
				<!-- Start Ads field -->

					<div class="form-group">
						<label class="col-sm-2 control-label">Allow Ads</label>
						<div class="col-sm-10 col-md-4">
							<div>
								<input id="ads-yes" type="radio" name="ads" value="0" <?php if ($row['AllowAds'] == 0) {echo 'checked';}?>>
								<label for="ads-yes">enable</label>
							</div>
							<div>
								<input id="ads-no" type="radio" name="ads" value="1" <?php if ($row['AllowAds'] == 1) {echo 'checked';}?>>
								<label for="ads-no">disable</label>
							</div>
						</div>
					</div>

				<!-- Start button field -->

					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
						<input type="submit" value="Add Category" class="btn btn-info">
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
		============================
		| UPDATE CATEGORIES PAGE   |
		===========================
		*/
			
		} elseif ($do == 'Update') {
			echo '<div class="ehead"> <h1 class="text-center">Update Categories Page</h1></div>';
			echo '<div class="container">';
			echo '<div class="col-md-6">';

			// ~ Check if the cats come form a POST Request or directly ?
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				// Get variables from the FORM
				$id = $_POST['id'];
				$name = $_POST['name'];
				$description = $_POST['description'];
				$order = $_POST['ordering'];
				$vis = $_POST['visibility'];
				$comm = $_POST['comments'];
				$ads = $_POST['ads'];

				

				// Check if there is no error ?
				if ($name != '') {

					//~ UPDATE the database with thos info
					$stmt = $con->prepare("UPDATE cats SET Name = ?, Description = ?, Ordering = ?, Visibility = ?, AllowComment = ?, AllowAds = ? WHERE ID = ?");
					$stmt->execute(array($name, $description, $order, $vis, $comm, $ads, $id));

					// Echo Sucess message with the number of records
					$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' category updated' . '</div>';
					redirectHome($theMsg, 'cats.php');

				}
				
			} else {
				$theMsg = '<div class="alert alert-danger">You can\'t browse this page directly</div>';
				redirectHome($theMsg);
			}
			echo '</div>';
			echo '</div>';

		/*
		============================
		| DELETE CATEGORIES PAGE   |
		===========================
		*/

		} elseif ($do == 'Delete') {

			echo '<div class="ehead"> <h1 class="text-center">Delete Users Page</h1></div>';
			echo '<div class="container">';

			// ~Check if GET Request catid is numeric and get the integer value of it
			$catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

			// ~Select all data depend on this ID
			$stmt = $con->prepare("SELECT * FROM cats WHERE ID = ? LIMIT 1");

			// ~Execute the query

			$stmt->execute(array($catid));

			// If there's such ID Delete the Category

			$count = $stmt->rowCount();

			if ($count > 0 ) {
				
				$stmt  = $con->prepare("DELETE FROM cats WHERE ID = :zcat");
				$stmt->bindParam(":zcat", $catid);
				$stmt->execute();

				// Echo Sucess message with the number of records
				
				$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Category deleted' . '</div>';
				redirectHome($theMsg,'back',2);

			} else {
				$theMsg = '<div class="alert alert-success">category not found!</div>';
				redirectHome($theMsg, 'users.php',4);
			}

			echo '</div>';


/*=============================================== END CONTENTS ====================================================*/

		/*
		=======================
		| REDIRECT CATS PAGE  |
		=======================
		*/

		} else {
			echo 'another Page';
		}



		include $tpl . 'footer.php';
	} else {
		header('Location: index.php');
		exit();
	}

?>



