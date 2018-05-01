<?php
	require('../resources/php/master.php');
	?>
	
<!DOCTYPE html>
<html>
	<head>
	<?php
	$title = "Logout";
	require('../resources/global/meta-head.php');
	?>
	<style>
	#logout-wrapper{
		margin: 5% 35%;
	}
	.logout{
		padding: 10px;
		background-color: #FFF;
		border: 1px solid #e3e3e3;
		border-radius: 0px 0px 5px 5px;
		box-shadow: 0px 10px 10px rgba(52, 58, 64, 0.8);
	}
	@media all and (max-width: 768px){
		#logout-wrapper{
		margin: 5px;
	}
	}
	</style>
	</head>
	<body>
	<?php
	//require('../resources/global/header.php');
	?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div id="logout-wrapper">
					<div class="text-center" style="margin-bottom: 10px">
						<a href="../" class="btn"><i class="fas fa-home"></i>  Go Back to Home Page</a>
					</div>

						<div class="contain-heading">
							<h3  class="text-center">Logout</h3>
						</div>
						<div class="logout text-center">
						<?php
						if($status == null){//if user was not loggged in before
							?>
							<p>You were not logged in before</p><br/>
							<a href="login.php" class="btn">Login Now</a>
							<?php
						}
						else{
							setcookie('myBlog','',time()-3600,'/');//unset the user cookie
							?>
							<p>You are now logged out</p><br/>
							<a href="login.php" class="btn">Login Back</a>
							<?php
						}
						?>
						</div>
			</div>
		</div>
	</div>
	</div>
	<?php
	require('../resources/global/footer.php');
	?>	</body>
</html>