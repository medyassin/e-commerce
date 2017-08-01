<?php
	include 'init.php';
?>

	<div class="container">
		<div class="login row">
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
				<div class="col-md-5 signup">
					<div class="form-group">
						<label for="username" class="control-label">Username</label>
						<input type="text" class="form-control" name="username" id="username" placeholder="username" autocomplete="off" required>
					</div>

					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" class="form-control" name="password" id="password" placeholder="password" autocomplete="new-password" required>
					</div>

					<div class="form-group">
						<label for="fullName">Full Name</label>
						<input type="text" class="form-control" name="fullname" id="fullName" placeholder="Full Name">
					</div>

					<div class="form-group">
						<label for="eMail">Email</label>
						<input type="text" class="form-control" name="email" id="eMail" placeholder="email" autocomplete="off" required>
					</div>

					<input type="submit" class="btn-signup" value = "Sign In">
				</div>
			</form>
			<form>
				<div class="col-xs-12 col-md-2 text-center">
					<span class="or">or</span>
				</div>

				<div class="col-md-5 signin">
					<div class="form-group">
						<label for="username">Username</label>
						<input type="text" class="form-control" name="username" id="username" placeholder="username" autocomplete="off" required>
					</div>

					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" class="form-control" name="password" id="password" placeholder="password" autocomplete="new-password" required>
					</div>

					<input type="submit" class="btn-signin" value = "Sign In">
				</div>
			</form>
		</div>
	</div>

<?php
	include $tpl . 'footer.php';


