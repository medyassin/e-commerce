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
      <a class="navbar-brand" href="index.php"><i class="fa fa-gears"></i><?php echo " " . lang('HOMEADMIN')?></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="mobile-nav">
      <ul class="nav navbar-nav">
        <li><a href="cats.php"><i class="fa fa-shopping-basket"></i><?php echo " " . lang('CATEGORIES')?></a></li>
        <li><a href="items.php"><i class="fa fa-sliders"></i><?php echo " " . lang('ITEMS')?></a></li>
        <li><a href="users.php"><i class="fa fa-users"></i><?php echo " " . lang('MEMEBERS')?></a></li>
        <li><a href="comments.php"><i class="fa fa-comments"></i><?php echo " " . lang('COMMENTS')?></a></li>
        <li><a href="#"><i class="fa fa-area-chart"></i><?php echo " " . lang('STATISTICS')?></a></li>
        <li><a href="#"><i class="fa fa-file-text-o"></i><?php echo " " . lang('LOGS')?></a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['Username'] ;?> <span class="fa fa-align-right"></span></a>
          <ul class="dropdown-menu">
            <li><a href="users.php?do=Edit&userid=<?php echo $_SESSION['ID'] ?>"><i class="fa fa-user"></i> Edit Profile</a></li>
            <li><a href="#"><i class="fa fa-gear"></i> Settings</a></li>
            <li><a href="logout.php"><i class="fa fa-sign-out"></i> Log out</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>