<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">myBlog</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="<?php echo SITE::$root ?>"><i class="fas fa-home"></i>  Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo SITE::$root.'/admin' ?>"><i class="fas fa-plus"></i>  New Post</a>
      </li>
      <li class="nav-item dropdown">
	  <?php
	  if($status == null){
	  ?>
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user"></i> Admin
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="<?php echo SITE::$root.'/admin/login.php'?>">Login</a>
          <!--<a class="dropdown-item" href="<?php echo SITE::$root.'/admin/register.php'?>">Register New Admin</a>-->
        </div>
		<?php
	  }
	  else{
		  ?>
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user"></i> <?php echo $admin->fullName ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="<?php echo SITE::$root.'/admin/register.php'?>">Register New Admin</a>
          <a class="dropdown-item" href="<?php echo SITE::$root.'/admin/logout.php'?>">Logout</a>
        </div>
		  <?php
	  }
	  ?>
      </li>
    </ul>
  </div>
</nav>