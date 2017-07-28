<?php
	/*
	==================================================
	==> Items Page
	==================================================
	*/
	ob_start(); // To store all output before senting headers => avoid header already sent probleme

	session_start(); // Start Session

	$pageTitle = 'Items';

	if (isset($_SESSION['Username'])) { // Check IF the User is Logged IN


		include 'init.php'; // Include Init.php

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage'; // CREATE PAGES USING ?do= REQUEST

		/*
		========================
		|  MANAGE ITEMS PAGE         |
		========================
		*/

		if ($do == 'Manage') {
			echo '<div class="ehead"> <h1 class="text-center">Manage Items</h1></div>';
			echo '<div class="container">';

			$stmt = $con->prepare("

									SELECT
										items.*,
										cats.Name AS cat_name,
										users.Username AS user_name
									FROM 
										items
									INNER JOIN 
										cats 
									ON 
										cats.ID = items.Cat_ID
									INNER JOIN
										users 
									ON
										users.UserID = items.User_ID
									ORDER BY Item_ID DESC
								"); 

			$stmt->execute(); // Execute the statement

			$items = $stmt->fetchAll(); // Fetch all data

			if (!empty($items)) {

		?>
			<!-- HEADING OF THE PAGE -->
				<div class="table-responsive">
					<table class="main-table text-center table">
						<tr>
							<td>#ID</td>
							<td>Name</td>
							<td>Description</td>
							<td>Price</td>
							<td>Adding date</td>
							<td>Category</td>
							<td>User</td>
							<td>Control</td>
						</tr>

						<?php

						foreach($items as $item) {

							echo "<tr>"; // START TAbLE ROW
								echo "<td>" . $item['Item_ID'] . "</td>";
								echo "<td>" . $item['Name'] . "</td>";
								echo "<td>" . $item['Description'] . "</td>";
								echo "<td>" . $item['Price'] . "</td>";
								echo "<td>" . $item['Add_Date'] . "</td>";
								echo "<td>" . $item['cat_name'] . "</td>";
								echo "<td><a href='". "profile.php?userid=" . $item['User_ID'] ."'>" . $item['user_name'] . "</a></td>";
								
								echo "<td>";
									echo "<a href='?do=Edit&itemid=" . $item['Item_ID'] . "'" . "class='btn btn-info'>";
									echo "<i class='fa fa-edit'></i>Edit</a> ";

									echo "<a href='?do=Delete&itemid=" . $item['Item_ID'] . "'" . "class='btn btn-danger confirm'>";
									echo "<i class='fa fa-close'></i>Delete</a> ";

								// Case Item is Not Approved yet ==> Show Btn of approvation
								if ($item['Approve'] == 0) {
									echo "<a href='?do=Approve&itemid=" . $item['Item_ID'] . "'" . "class='btn btn-success activate'><i class='fa fa-check'></i>Approve</a>";
								}
								
								echo "</td>";

							echo "</tr>"; // END TAbLE ROW
						}

						?>

					</table>
				</div>
				<a class="btn btn-sm btn-primary" href="?do=Add"><i class='fa fa-plus'></i> new item</a>
			</div>
		<?php 
			} else {

			echo '<div class="container">';
				$theMsg = "<div class='alert alert-info'> There is no items</div>";
				redirectHome($theMsg, 'index.php', 2);
			echo '</div>';

			}
		?>
		<?php
		/*
		========================
		|  ADD NEW ITEMS PAGE   |
		========================
		*/

		} elseif ($do == 'Add') { 

			// Fetch data to use it in user and cats forms 

			$stmt5 = $con->prepare("SELECT * FROM users");
			$stmt5->execute();
			$users = $stmt5->fetchAll();

			$stmt6 = $con->prepare("SELECT * FROM cats");
			$stmt6->execute();
			$cats = $stmt6->fetchAll();

			// END FETCH DATA ?>

			<!-- Heading of the Page -->

			<div class="ehead"> <h1 class="text-center">Add Items Page</h1></div>

			<!-- STRUCTURE OF THE PAGE -->
			
			<div class=container >

				<form class="form-horizontal" action="?do=Insert" method="POST">

				<!-- Start Name field -->

					<div class="form-group">
						<label class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10 col-md-4">
						<input  
								type="text"
								name="name" 
								class="form-control" 
								required="required" 
								placeholder="Name of the Item">
						</div>
					</div>

				<!-- Start Description field -->

					<div class="form-group">
						<label class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10 col-md-4">
						<input  
								type="text"
								name="description" 
								class="form-control" 
								required="required"
								placeholder="Description of the Item">
						</div>
					</div>

				<!-- Start Price field -->

					<div class="form-group">
						<label class="col-sm-2 control-label">Price</label>
						<div class="col-sm-10 col-md-4">
						<input  
								type="text"
								name="price" 
								class="form-control"
								required="required"
								placeholder="Price of the Item">
						</div>
					</div>

				<!-- Start Country made field -->

					<div class="form-group">
						<label class="col-sm-2 control-label">Country</label>
						<div class="col-sm-10 col-md-4">
						<input  
								type="text"
								name="country" 
								class="form-control"
								required="required"
								placeholder="country of made">
						</div>
					</div>

				<!-- Start Status made field -->

					<div class="form-group">
						<label class="col-sm-2 control-label">Status</label>
						<div class="col-sm-10 col-md-4">
						<select name="status">
							<option value="0">....</option>
							<option value="1">News</option>
							<option value="2">Like New</option>
							<option value="3">Used</option>
							<option value="4">Very Old</option>
						</select>
						</div>
					</div>

				<!-- Start Users field -->

					<div class="form-group">
						<label class="col-sm-2 control-label">User</label>
						<div class="col-sm-10 col-md-4">
						<select name="user">
							<option value="0">....</option>
							<?php

								foreach($users as $user) {
									echo "<option value='" . $user['UserID'] ."'>" . $user['FullName'] ."</option>";
								}

							?>
						</select>
						</div>
					</div>

				<!-- Start Categories field -->

					<div class="form-group">
						<label class="col-sm-2 control-label">Catgeory</label>
						<div class="col-sm-10 col-md-4">
						<select name="category">
							<option value="0">....</option>
							<?php

								foreach($cats as $cat) {
									echo "<option value='" . $cat['ID'] ."'>" . $cat['Name'] ."</option>";
								}

							?>
						</select>
						</div>
					</div>

				<!-- Start button field -->

					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
						<input type="submit" value="Add Item" class="btn btn-info">
						</div>
					</div>
				</form>
			</div>

		<?php

		/*
		=======================
		| INSERT ITEMS PAGE   |
		=======================
		*/

		} elseif ($do == 'Insert') { 


			// HEADING OF THE PAGE

			echo '<div class="ehead"> <h1 class="text-center">Insert Items Page</h1></div>';
			echo '<div class="container">';
				
			// Check if the User Access From a POST REQUEST

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				
				// Get Datas from the FORM AND Store it;

				$name    = $_POST['name'];
				$desc    = $_POST['description'];
				$price   = $_POST['price'];
				$country = $_POST['country'];
				$status  = $_POST['status'];
				$user    = $_POST['user'];
				$cat     = $_POST['category'];

				// Validate the Form

				$formErrors = array();

				if (empty($name)) {
					$formErrors[] = 'name cant be <strong>empty</strong>';
				}

				if (empty($desc)) {
					$formErrors[] = 'Description can\'t be <strong>empty</strong>';
				}

				if (empty($price)) {
					$formErrors[] = 'Price can\'t be <strong>empty</strong>';
				}

				if (empty($country)) {
					$formErrors[] = 'Country can\'t be <strong>empty</strong>';
				}

				if ($status === '0') {
					$formErrors[] = 'you must <strong>select</strong> the status';
				}

				if ($user === '0') {
					$formErrors[] = 'you must <strong>select</strong> the user';
				}

				if ($cat === '0') {
					$formErrors[] = 'you must <strong>select</strong> the category';
				}

				foreach($formErrors as $error) {
					echo '<div class="alert alert-danger">' . $error ."</div>";
				}

				// Check if there is no error = $formErrors Array empty !

				if (empty($formErrors)) {

					// Check If the Items exist in Database


						// Insert New Item into database

						$stmt4 = $con->prepare("INSERT INTO items(Name, Description, Price, Add_Date, Country_Made, Status, Cat_ID, User_ID)
												VALUES(:zname, :zdesc, :zprice, now(), :zcountry, :zstatus, :zcat, :zuser)");
						$stmt4->execute(array(

							'zname'     => $name,
							'zdesc'     => $desc,
							'zprice'    => $price,
							'zcountry'  => $country,
							'zstatus'   => $status,
							'zcat'      => $cat,
							'zuser'     => $user

						));

						// Echo Sucess message with the number of records
						$theMsg = '<div class="alert alert-success">' . $stmt4->rowCount() . ' Item(s) inserted' . '</div>';
						redirectHome($theMsg, 'items.php', 2);

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
		| EDIT ITEMS PAGE   |
		=======================
		*/

		} elseif ($do == 'Edit') {

			$stmt5 = $con->prepare("SELECT * FROM users");
			$stmt5->execute();
			$users = $stmt5->fetchAll();

			$stmt6 = $con->prepare("SELECT * FROM cats");
			$stmt6->execute();
			$cats = $stmt6->fetchAll();


			// Check if GET Request itemid is numeric and get the integer value of it

			$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

			// ~Select all data depend on this ID
			$stmt = $con->prepare("SELECT * FROM items WHERE Item_ID = ?");

			// ~Execute the query
			$stmt->execute(array($itemid));

			// Fetch the Data
			$item = $stmt->fetch();

			// If there's such ID show the form
			$count = $stmt->rowCount();
		
			if ($count > 0 ) { ?>
			
				<div class="ehead">
					<h1 class="text-center">Edit items Page</h1>
				</div>
				
			<!-- STRUCTURE OF THE PAGE -->
			
			<div class=container >

				<form class="form-horizontal" action="?do=Update" method="POST">

				<!-- Start Name field -->
					<input type='text' class='hidden' value="<?php echo $item['Item_ID'] ?>" name="itemid">
					<div class="form-group">
						<label class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10 col-md-4">
						<input  
								type="text"
								name="name" 
								class="form-control" 
								required="required" 
								placeholder="Name of the Item"
								value="<?php echo $item['Name'] ?>"

								>
						</div>
					</div>

				<!-- Start Description field -->

					<div class="form-group">
						<label class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10 col-md-4">
						<input  
								type="text"
								name="description" 
								class="form-control" 
								required="required"
								placeholder="Description of the Item"
								value="<?php echo $item['Description'] ?>";

								>
						</div>
					</div>

				<!-- Start Price field -->

					<div class="form-group">
						<label class="col-sm-2 control-label">Price</label>
						<div class="col-sm-10 col-md-4">
						<input  
								type="text"
								name="price" 
								class="form-control"
								required="required"
								placeholder="Price of the Item"
								value="<?php echo $item['Price'] ?>";
								>
						</div>
					</div>

				<!-- Start Country made field -->

					<div class="form-group">
						<label class="col-sm-2 control-label">Country</label>
						<div class="col-sm-10 col-md-4">
						<input  
								type="text"
								name="country" 
								class="form-control"
								required="required"
								placeholder="country of made"
								value="<?php echo $item['Country_Made'] ?>"; 
								>
						</div>
					</div>

				<!-- Start Status made field -->

					<div class="form-group">
						<label class="col-sm-2 control-label">Status</label>
						<div class="col-sm-10 col-md-4">
						<select name="status">
							<option value="0">....</option>
							<option value="1" <?php if ($item['Status'] == 1) { echo 'selected' ;} ?>>News</option>
							<option value="2" <?php if ($item['Status'] == 2) { echo 'selected' ;} ?>>Like New</option>
							<option value="3" <?php if ($item['Status'] == 3) { echo 'selected' ;} ?>>Used</option>
							<option value="4" <?php if ($item['Status'] == 4) { echo 'selected' ;} ?>>Very Old</option>
						</select>
						</div>
					</div>

				<!-- Start Users field -->

					<div class="form-group">
						<label class="col-sm-2 control-label">User</label>
						<div class="col-sm-10 col-md-4">
						<select name="user">
							<option value="0">....</option>
							<?php

								foreach($users as $user) {
									echo "<option value='" . $user['UserID'] ."'"; 
									if ($item['User_ID'] == $user['UserID']) {echo 'selected';} 
									echo ">" . $user['FullName'] ."</option>";
								}

							?>
						</select>
						</div>
					</div>

				<!-- Start Categories field -->

					<div class="form-group">
						<label class="col-sm-2 control-label">Catgeory</label>
						<div class="col-sm-10 col-md-4">
						<select name="category">
							<option value="0">....</option>
							<?php

								foreach($cats as $cat) {
									echo "<option value='" . $cat['ID'] ."'";
									if ($item['Cat_ID'] == $cat['ID']) {echo 'selected';} 
									echo ">" . $cat['Name'] ."</option>";
								}

							?>
						</select>
						</div>
					</div>

				<!-- Start button field -->

					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
						<input type="submit" value="Update" class="btn btn-info">
						</div>
					</div>
				</form>


				<!-- START Comments Area -->

				<?php
					$stmt = $con->prepare("SELECT comments.*, users.Username AS user_name
											FROM comments
											INNER JOIN users 
											ON users.UserID = comments.c_user_id
											WHERE c_item_id = ?");
					$stmt->execute(array($itemid)); // Execute the statement
					$rows = $stmt->fetchAll(); // Fetch all data


					if(!empty($rows)) {
				?>
				<!-- HEADING OF THE PAGE -->
				<div class="ehead"> <h1 class="text-center"><?php echo $item['Name'] ?> - Comments</h1></div>
					<div class="table-responsive">
						<table class="main-table text-center table table-bordered">
							<tr>
								<td>Comment</td>
								<td>User name</td>
								<td>Added date</td>
								<td>Control</td>
							</tr>

							<?php

							foreach($rows as $row) {

								echo "<tr>"; // START TAbLE ROW
									echo "<td>" . $row['c'] . "</td>";
									echo "<td>" . $row['user_name'] . "</td>";
									echo "<td>" . $row['c_date'] . "</td>";
									
									echo "<td>";
										echo "<a href='comments.php?do=Edit&cid=" . $row['c_id'] . "'" . "class='btn btn-success'>";
										echo "<i class='fa fa-edit'></i>Edit</a> ";

										echo "<a href='comments.php?do=Delete&cid=" . $row['c_id'] . "'" . "class='btn btn-danger confirm'>";
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
				<?php } ?>
			</div>


			<?php } else { // ~ Show Error Message ~ No Id Found ~
				echo '<div class="container">';
				$theMsg = "<div class='alert alert-danger'>this item not found in our databases ! try again</div>";
				redirectHome($theMsg);
				echo '</div>';
			} 

		/*
		=======================
		| UPDATE ITEMS PAGE   |
		=======================
		*/

		} elseif($do == 'Update') {

			echo '<div class="ehead"> <h1 class="text-center">Update Items Page</h1></div>';
			echo '<div class="container">';
			echo '<div class="col-md-6">';

			// ~ Check if the user come form a POST Request or directly ?
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				// Get variables from the FORM
				$id      = $_POST['itemid'];
				$name    = $_POST['name'];
				$desc    = $_POST['description'];
				$price   = $_POST['price'];
				$country = $_POST['country'];
				$status  = $_POST['status'];
				$user    = $_POST['user'];
				$cat     = $_POST['category'];


				// ~ Validate the Form
				$formErrors = array();

				if (empty($name)) {
					$formErrors[] = 'name cant be <strong>empty</strong>';
				}

				if (empty($desc)) {
					$formErrors[] = 'Description can\'t be <strong>empty</strong>';
				}

				if (empty($price)) {
					$formErrors[] = 'Price can\'t be <strong>empty</strong>';
				}

				if (empty($country)) {
					$formErrors[] = 'Country can\'t be <strong>empty</strong>';
				}

				if ($status === '0') {
					$formErrors[] = 'you must <strong>select</strong> the status';
				}

				if ($user === '0') {
					$formErrors[] = 'you must <strong>select</strong> the user';
				}

				if ($cat === '0') {
					$formErrors[] = 'you must <strong>select</strong> the category';
				}

				foreach($formErrors as $error) {
					echo '<div class="alert alert-danger">' . $error ."</div>";
				}

				// Check if there is no error ?
				if (empty($formErrors)) {

					//~ UPDATE the database with thos info
					$stmt = $con->prepare("UPDATE items SET Name = ?, Description = ?, Price = ?, Country_Made = ?, Status = ?, Cat_ID = ?, User_ID = ? WHERE Item_ID = ?");
					$stmt->execute(array($name, $desc, $price, $country, $status, $cat, $user, $id));

					// Echo Sucess message with the number of records
					$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Records updated' . '</div>';
					redirectHome($theMsg, 'items.php',2);

				}
				
			} else {
				$theMsg = '<div class="alert alert-danger">You can\'t browse this page directly</div>';
				redirectHome($theMsg);
			}
			echo '</div>';
			echo '</div>';

		/*
		=======================
		| DELETE ITEMS PAGE   |
		=======================
		*/

		} elseif ($do == 'Delete') { 

			echo '<div class="ehead"> <h1 class="text-center">Delete Items Page</h1></div>';
			echo '<div class="container">';

			// ~Check if GET Request userid is numeric and get the integer value of it
			$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

			// ~Select all data depend on this ID
			$stmt = $con->prepare("SELECT * FROM items WHERE Item_ID = ?");

			// ~Execute the query
			$stmt->execute(array($itemid));

			// If there's such ID DELETE the User
			$count = $stmt->rowCount();

			if ($count > 0 ) {
				
				$stmt  = $con->prepare("DELETE FROM items WHERE Item_ID = :zitem");
				$stmt->bindParam(":zitem", $itemid);
				$stmt->execute();

				// Echo Sucess message with the number of records
				
				$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' item(s) deleted' . '</div>';
				redirectHome($theMsg,'back',2);

			} else {
				$theMsg = '<div class="alert alert-success">Sorry, this item doesn\'t exist in our databases</div>';
				redirectHome($theMsg, 'items.php',4);
			}

			echo '</div>';

		/*
		==========================
		|  APPROVE ITEMS PAGE   |
		=========================
		*/


		} elseif($do == 'Approve') {
			// approve items Page
			echo '<div class="ehead"> <h1 class="text-center">Approve Items Page</h1></div>';
			echo '<div class="container">';

			$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

			$check = checkItem('Item_ID', 'items', $itemid);

			if ($check > 0 ) {
				
				$stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE Item_ID = ?");
				$stmt->execute(array($itemid));

				// Echo Sucess message with the number of records
				$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Records Activated' . '</div>';
				redirectHome($theMsg,'back',2);

			} else {
				$theMsg = '<div class="alert alert-success">Items(s) not found!</div>';
				redirectHome($theMsg, 'items.php',4);
			}

			echo '</div>';

		}

	include $tpl . 'footer.php';


	} else {

		header('Location: index.php');
		
		exit();

	}


ob_end_flush(); // Sent Outpute After Storing It