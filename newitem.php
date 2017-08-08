<?php
	ob_start();
	session_start();
	$pageTitle = ' Add New Item';
	include 'init.php';

	if(isset($_SESSION['user'])) {

	if($_SERVER['REQUEST_METHOD'] == 'POST') {
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

		$title    = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
		$desc     = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
		$price    = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
		$country  = filter_var($_POST['country'], FILTER_SANITIZE_STRING);
		$status   = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
		$category = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);


		if (strlen($title) < 4) {
			$formErrors[] = 'Item Title Must Be At Least 4 Characters';
		}

		if (strlen($desc) < 10) {
			$formErrors[] = 'Item Description Must Be At Least 10 Characters';
		}

		if (strlen($country) < 2) {
			$formErrors[] = 'Item Title Must Be At Least 2 Characters';
		}

		if (empty($price)) {
			$formErrors[] = 'Item Price Cant Be Empty';
		}

		if (empty($status)) {
			$formErrors[] = 'Item Status Cant Be Empty';
		}

		if (empty($category)) {
			$formErrors[] = 'Item Category Cant Be Empty';
		}
		
		if (empty($formErrors)) {

			$image = rand(0,1000000) . '_' . $imgName;

			move_uploaded_file($imgTmp, 'C:\XAMPP\htdocs\eCommerce\data\uploads\items\\' . $image);

			// Insert New Item into database

			$stmt4 = $con->prepare("INSERT INTO items(Name, Description, Price, Add_Date, Country_Made, Image, Status, Cat_ID, User_ID)
									VALUES(:zname, :zdesc, :zprice, now(), :zcountry, :zimg, :zstatus, :zcat, :zuser)");
			$stmt4->execute(array(

				'zname'     => $title,
				'zdesc'     => $desc,
				'zprice'    => $price,
				'zcountry'  => $country,
				'zimg'      => $image,
				'zstatus'   => $status,
				'zcat'      => $category,
				'zuser'     => $_SESSION['uid']

			));

			// Echo Sucess message with the number of records
			$sucessMsg = 'Congrat, your are is added, and waiting approvement ...';

		}

		
	}


	?>
	<!-- Start Page Heading -->
	<div class="container">
		<h1><?php echo 'Add new Item' ?></h1>
	</div>
	<!-- End Page Heading -->

	<!-- Start Add item -->
	<div class="create-ad  items block">
		<div class="container">
		<!-- Start Errors Area -->
		<div class="the-errors">
		<?php
			if(! empty($formErrors)) {
				foreach($formErrors as $error) {
					echo '<div class="alert alert-danger">' . $error . '</div>';
				}
			}

			if(isset($sucessMsg)) {
				echo '<div class="msg success">' . $sucessMsg . '</div>';
			}
		?>
		</div>
		<!-- End Errors Area -->
			<div class="panel panel-default">
				<div class="panel-heading">
					Create New Item
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-9">
							<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">

							<!-- Start Name field -->

								<div class="form-group">
									<label class="col-sm-2 control-label">Name</label>
									<div class="col-sm-10 col-md-9">
									<input  
											type="text"
											name="name" 
											class="form-control live" 
											
											placeholder="Name of the Item"
											data-class=".live-title">
									</div>
								</div>

							<!-- Start Description field -->

								<div class="form-group">
									<label class="col-sm-2 control-label">Description</label>
									<div class="col-sm-10 col-md-9">
									<input  
											type="text"
											name="description" 
											class="form-control live" 
											
											placeholder="Description of the Item"
											data-class=".live-desc">
									</div>
								</div>

							<!-- Start Price field -->

								<div class="form-group">
									<label class="col-sm-2 control-label">Price</label>
									<div class="col-sm-10 col-md-9">
									<input  
											type="text"
											name="price" 
											class="form-control live"
											
											placeholder="Price of the Item"
											data-class=".live-price">
									</div>
								</div>

							<!-- Start Image field -->

								<div class="form-group">
									<label class="col-sm-2 control-label">Image</label>
									<div class="col-sm-10 col-md-9">
									<input  
											type="file"
											name="image" 
											class="form-control live"
											
											placeholder="Price of the Item"
											data-class=".live-image">
									</div>
								</div>

							<!-- Start Country made field -->

								<div class="form-group">
									<label class="col-sm-2 control-label">Country</label>
									<div class="col-sm-10 col-md-9">
									<input  
											type="text"
											name="country" 
											class="form-control live-country"
											
											placeholder="country of made">
									</div>
								</div>

							<!-- Start Status made field -->

								<div class="form-group">
									<label class="col-sm-2 control-label">Status</label>
									<div class="col-sm-10 col-md-9">
									<select name="status" data-class=".live-status">
										<option value="0">....</option>
										<option value="1">News</option>
										<option value="2">Like New</option>
										<option value="3">Used</option>
										<option value="4">Very Old</option>
									</select>
									</div>
								</div>

							<!-- Start Categories field -->

								<div class="form-group">
									<label class="col-sm-2 control-label">Catgeory</label>
									<div class="col-sm-10 col-md-9">
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
						<div class="col-md-3">
							<div class="item-box live-preview">
								<span class="status live-status">Status</span>
								<img src="https://static.jumia.ma/PpDM-tTUwciHSJT88whLP8ANL5Y=/fit-in/220x220/filters:fill(white)/product/35/384571/1.jpg?1157" alt="item-image">
								<span class="user">Category</span>
								<span class="title live-title">Item Title</span>
								<span class="price"><span class="live-price">0</span> dhs</span>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Add Item -->

	<?php } else {
		header('Location: login.php');
	}

	include $tpl . 'footer.php';
	ob_end_flush();
?>