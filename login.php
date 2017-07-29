<?php
	include 'init.php';
?>

	<div class="container">
		<div class="login">
			<h3 class="text-center">Un seul compte. Tous les services.</h3>
			<h5 class="text-center">Vous pouvez maintenant accéder avec le même compte à tous les services suivants</h5>

			<div class="services text-center">
				<img src="data/uploads/icon-market-web.png" alt="services">
				<img src="data/uploads/icon-jumia-web.png" alt="services">
				<img src="data/uploads/icon-travel-web.png" alt="services">
				<img src="data/uploads/icon-deals-web.png" alt="services">
			</div>

			<p>Créer un nouveau compte client</p>

			<form action="<?php $_SERVER['PHP_SELF']?>" method="POST">
				<label for="username">Username</label>
				<input type="text" name="username" id="username">
			</form>
		</div>
	</div>

<?php
	include $tpl . 'footer.php';


