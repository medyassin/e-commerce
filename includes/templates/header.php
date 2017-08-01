<!DOCTYPE html>
	<head>
		<meta charset="UTF-8">
		<title><?php getTitle() ?></title>
		<link rel="stylesheet" href="<?php echo $css?>bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo $css?>jquery-ui.css">
		<link rel="stylesheet" href="<?php echo $css?>front.css">
		<link rel="stylesheet" href="<?php echo $css?>jquery.selectBoxIt.css">
		<link rel="stylesheet" href="<?php echo $css?>font-awesome.min.css">
		<link rel="stylesheethref" href="https://fonts.googleapis.com/css?family=Roboto">
	</head>
	<body>

		<?php if(isset($_SESSION['user'])) { ?>

			<div class="container">
				<div class="upper-bar pull-right">
						<span class="pull-right">
						<i class="fa fa-user"></i>
							welcome <?php echo $_SESSION['user'];
							if(checkUserStatus($_SESSION['user']) == 1) {
								echo ' <span class="alert alert-danger">You are account is not activated yet !</span>';} 
							?>
						<a class="alert alert-info" href="profile.php">my profile</a>
						<a class="alert alert-success" href="logout.php">logout</a>
						</span>
				</div>
			</div>

		<?php } else {?>

			<div class="container">
				<div class="upper-bar pull-right">
					<a href="login.php">
						<span class="pull-right"><i class="fa fa-user"></i> Login/Signup</span>
					</a>
				</div>
			</div>

		<?php } ?>

		<nav class="navbar navbar-default">
		  <div class="container">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mobile-nav" aria-expanded="false">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand" href="index.php"><img src="data/uploads/logo.png" alt="logo"></a>
		    </div>

		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="mobile-nav">
		      <ul class="nav navbar-nav navbar-right">

		      	<?php 

		      		$cats = getCat();
		      		$icons = array('fa-bath','fa-desktop', 'fa-amazon', 'fa-slideshare', 'fa-bed', 'fa-home');

		      		foreach(array_combine($icons, $cats) as $icon => $cat) {
		      			echo '<li><a href="cats.php?catid='. $cat['ID'] . '&name=' . strtolower(str_replace(' ', '-',$cat['Name'])) .'"><i class="fa ' . $icon . '"></i> ' . $cat['Name'] . '</a></li>';
		      		}


		      	?>
		      </ul>
		    </div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>