<?php
	require('../resources/php/master.php');
	
	if(isset($_POST['register'])){		
		$firstName = $_POST['first_name'];
		$lastName = $_POST['last_name'];
		$username = $_POST['username'];
		$pass01 = $_POST['password01'];
		$pass02 = $_POST['password02'];
		if($firstName == '' || $lastName == '' || $username == '' || $pass01 == '' || $pass02 == '' ){
			$registerError = "Please fill all fields correctly";
		}else{
			if($pass01 == $pass02){
				$data = array('first_name'=>$firstName,'last_name'=>$lastName,'username'=>$username,'password'=>$pass02);
				$reg = $put->newAdmin($data);
					if($reg == 000){
						$registerSuccess = "New admin <strong>$firstName $lastName</strong> have been registered successfully";
					}
					else{
						switch($reg){
							case 111:
							$registerError = "The username <strong>$username</strong> is already taken by another admin";
							break;
							case 999:
							$registerError = "Registration failed, something went wrong. Try again";
							break;
							default:
							$registerError = "An unknown error occurred. Try again";
							break;
						}
					}
				}
			else{
				$registerError = "Passwords do not match, try again";
			}
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
	<?php
	$title = "Register";
	require('../resources/global/meta-head.php');
	?>
	<style>
	#register-wrapper{
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
		#register-wrapper{
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
				<div id="register-wrapper">
				<div class="text-center" style="margin-bottom: 10px">
					<a href="../" class="btn"><i class="fas fa-home"></i>  Go to Home Page</a>
				</div>
					<div class="contain-heading">
						<h3  class="text-center">Register New Admin</h3>
					</div>
					<form action="<?php $_PHP_SELF ?>" method="POST">
						<?php
						if($status == null){//if not logged in as admin
							?>
							<div class="text-center">
								<h4>Access Denied</h4>
								<p>You need to be logged in as admin to register another admin</p>
								<br><a href="../admin/login.php" class="btn" style="color:#fff">Login Now</a></div>
							<?php
						}else{
							if(isset($registerSuccess)){
							?>
							<div class="alert alert-success text-center" role="alert">
								<i class="fas fa-check-circle"></i>  <?php echo $registerSuccess ?>
							</div>
							<?php
							}
							else{
							if(isset($registerError)){
							?>
							<div class="alert alert-danger text-center" role="alert">
								<i class="fas fa-times-circle"></i>  <?php echo $registerError ?>
							</div>
									<?php
								}
								?>
						  <div class="form-group">
								<label>First Name</label>
								<input type="text" name="first_name" class="form-control" placeholder="Enter first name" value="<?php echo (isset($_POST['first_name']) ? $_POST['first_name'] : '' ) ?>" required>
						  </div>
						  <div class="form-group">
								<label>Last Name</label>
								<input type="text" name="last_name" class="form-control" placeholder="Enter last name" value="<?php echo (isset($_POST['last_name']) ? $_POST['last_name'] : '' ) ?>" required>
						  </div>
						  <div class="form-group">
								<label>Username</label>
								<input type="text" name="username" class="form-control" placeholder="Enter username" value="<?php echo (isset($_POST['username']) ? $_POST['username'] : '' ) ?>" required>
						  </div>
						  <div class="form-group">
								<label>Choose password</label>
								<input type="password" name="password01" class="form-control" placeholder="Enter password"  required>
						  </div>
						  <div class="form-group">
								<label>Repeat</label>
								<input type="password" name="password02" class="form-control" placeholder="Confirm password" required>
						  </div>
						  <div class="text-center">
							<button type="submit" name="register" class="btn">Register</button>
						  </div>
						 <!-- <p class="text-right">Already registered? <a href="login.php">Login instead</a></p>-->
						<?php
							}
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