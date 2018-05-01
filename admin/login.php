<?php
	require('../resources/php/master.php');
	if(isset($_POST['login'])){
		if(isset($_POST['keepLoggedIn']) && $_POST['keepLoggedIn'] == 1){
			$_POST['stay_logged_in'] = 1;
		}
		else{
			$_POST['stay_logged_in'] = 0;
		}
		$login = new LOGIN($_POST);
		$loginReport = $login->verify();
		if($loginReport == 000){
			$goto = '../admin';
			if(isset($_GET['_rdr'])){
				$goto = $_GET['_rdr'];
			}
			$tool->redirect_to($goto);
		}else{
		switch($loginReport){
				case 101:
				$loginError =  "Incorrect password";
				break;
				case 102:
				$loginError = "Username ".$_POST['username']." does not exist";
				break;
				default:
				$loginError = "An unknown error occurred, try again";
				break;
			}
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
	<?php
	$title = "Login";
	require('../resources/global/meta-head.php');
	?>
	<style>
	#login-wrapper{
		margin: 5% 35%;
	}
	form{
		padding: 10px;
		background-color: #FFF;
		border: 1px solid #e3e3e3;
		border-radius: 0px 0px 5px 5px;
		box-shadow: 0px 10px 10px rgba(52, 58, 64, 0.8);
	}
	@media all and (max-width: 768px){
		#login-wrapper{
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
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 login-container">
				<div id="login-wrapper">
					<div class="text-center" style="margin-bottom: 10px">
						<a href="../" class="btn"><i class="fas fa-home"></i>  Go to Home Page</a>
					</div>

					<div class="contain-heading">
						<h3 class="text-center">Login</h3>
					</div>
					<form action="<?php $_PHP_SELF ?>" method="POST">
						<?php
						if($status != null){//if already logged in
							?>
							<div class="text-center">
							<p>You are already logged in as <?php echo $admin->fullName ?></p><br>
							<a href="../admin" class="btn" style="color:#fff">Go to Dashboard</a></div>
							<?php
						}else{
						if(isset($loginError)){
							?>
							<div class="alert alert-danger" role="alert">
								<i class="fas fa-times-circle"></i>  <?php echo $loginError ?>
							</div>
							<?php
						}
						?>
						  <div class="form-group">
								<label>Username</label>
								<input type="text" name="username" class="form-control" placeholder="Enter username" value="<?php echo (isset($_POST['username']) ? $_POST['username'] : '' ) ?>" required>
						  </div>
						  <div class="form-group">
								<label>Password</label>
								<input type="password" name="password" class="form-control" placeholder="Password" required>
						  </div>
						  <div class="form-group form-check">
								<input type="checkbox" name="keepLoggedIn" class="form-check-input" value="1" checked>
								<label class="form-check-label">Keep me Logged in</label>
						  </div>
						  <div class="text-center">
							<button type="submit" name="login" class="btn">Login</button>
						  </div>
						  <p class="text-right"><a href="register.php">Register new admin</a></p>
						<?php
						}
						?>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<?php
	require('../resources/global/footer.php');
	?>	</body>
</html>