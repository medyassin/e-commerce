<?php
	session_start();

	include 'init.php';

	$items = getItem($_GET['catid']);



	?>

	<!-- Start H1 -->
	<div class="cat-name">
		<div class="container">
			<h1><?php echo $_GET['name']?></h1>
		</div>
	</div>

	<?php if (! empty($items)) {?>
	<!-- Start Items Showcase -->
	<div class="items">
		<div class="container">
			<div class="row">

				<?php
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
								echo '<img src="' . $item['Image'] . '" alt="item-image">';
								echo '<span class="user">' . $item['user_name'] . '</span>';
								echo '<span class="title">' . $item['Name'] . '</span>';
								echo '<span class="price">' . $item['Price'] . '</span>';
								echo '<button>Buy Now</button>';
							echo '</div>';
						echo '</div>';
					}
				?>
			</div>
		</div>
	</div>

	<?php 
		} else {
			echo 'there is no item to show';
		}


	?>

	<?php

	include $tpl . 'footer.php';
?>