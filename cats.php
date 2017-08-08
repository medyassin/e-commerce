<?php
	session_start();

	include 'init.php';

	$items = getItem('Cat_ID', $_GET['catid']);



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

						echo '<div class="col-sm-4 col-md-3">';
							echo '<div class="item-box">';
								echo '<span class="status">' . getStatus($item['Status']) . '</span>';
								echo '<a href="item.php?itemid=' . $item['Item_ID'] . '"><img src="data/uploads/items/' . $item['Image'] . '" alt="item-image"></a>';
								echo '<span class="user">' . $item['user_name'] . '</span>';
								echo '<span class="title">' . $item['Name'] . '</span>';
								echo '<span class="price">' . $item['Price'] . ' DHS' . '</span>';
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
			echo '<div class="container">';
			echo '<div class="alert alert-info">there is no items to show</div>';
			echo '</div>';
		}


	?>

	<?php

	include $tpl . 'footer.php';
?>