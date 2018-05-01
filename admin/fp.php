		<?php
		function savePhoto($content){
			setcookie('fp',$content,time()+3600,'/');
		}
		if(isset($_GET['photo'])){ 
		class PHOTO{
			public function formatValid($format){

			$allowedFormats = array ('image/jpeg', 'image/JPG','image/gif', 'image/PNG','image/png', 'image/x-png');
				if (in_array($format,$allowedFormats)){
					return true;
				}
				else{
					return false;
				}
			}
			public function getFormat($filetype){
			$format = '.'.substr($filetype,1+strpos($filetype,'/'));
			return $format;
			}
			
			public function haltScript(){
				die();
			}
		}


		//This part is for uploading new avatar
			if(isset($_POST['uploadPhoto']) && isset($_FILES['photo'])){
				//print_r($_FILES);
				$photo = new PHOTO();
				$photoDir = "../images/featured-photos/";
				$now = time();
				$size = ($_FILES['photo']['size'])/1000000;
				if($_FILES['photo']['type'] != ''){
				$format = $photo->getFormat($_FILES['photo']['type']);
				//The function is_upload_image() is in master_script.php
				if($photo->formatValid($_FILES['photo']['type'])){
					$Upload_photoId = $_GET['photo'];
					$format = $photo->getFormat($_FILES['photo']['type']);
					$finalPhotoURL = $photoDir.$Upload_photoId.$format;
					if (!move_uploaded_file ($_FILES['photo']['tmp_name'],$finalPhotoURL)) {
					$uploadReport = 000; //Upload was not successfull
					//savePhoto($Upload_photoId.$format);
					//setcookie('fp',$Upload_photoId.$format,time()+36000,'/'); //store the photo name in a cookie for the script that will add the post to the database
					}
				else{
					//discard the tmp file
					if(is_file($_FILES['photo']['tmp_name']) && file_exists($_FILES['photo']['tmp_name'])){
						unlink($_FILES['photo']['tmp_name']);
								}
							$uploadReport = 111; // upload was successfull
					}	
				}
				else{
					$uploadReport = 999; //file format not allowed
				}
				}
				else{
					$uploadReport = 222; //no file type
				}			

			}
		}

		if(isset($uploadReport) && $uploadReport == 111){
			savePhoto($Upload_photoId.$format);
		}
			?>

<html>	
	<head>
	<link href="../resources/bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
	<link href="../resources/css/custom.css" type="text/css" rel="stylesheet" />
	<script  src="../resources/fontawesome-free-5.0.9/svg-with-js/js/fontawesome-all.min.js" type="text/javascript" language="javascript" ></script>
	<style>
	body{
		background: #FFF;
		padding: 20px;
	}
	img{
		width: 300px;
		height: auto;
		border-radius: 5px;
	}


	</style>
	</head>
	<body>
			<?php if(isset($uploadReport)){
				switch($uploadReport){
					case 000:
					?>
					<div class="alert alert-danger"><i class="fas fa-times-circle"></i>  File failed to upload! </div>
					<?php
					break;
					case 111:
					?>
					<div class="alert alert-success"><i class="fas fa-check-circle"></i>  Featured Photo uploaded successfully! </div>
					<img src="<?php echo $finalPhotoURL ?>" alt="Featured Photo">
					<style>
						form{
							display: none; /*Don't show the upload form again if already uploaded*/
						}
						</style>
					<?php
					break;
					case 222:
					?>
					<div class="alert alert-danger"><i class="fas fa-times-circle"></i>  No file selected! </div>
					<?php
					break;
					case 999:
					?>
					<div class="alert alert-danger"><i class="fas fa-times-circle"></i>  File format <strong>(<?php echo $format ?>)</strong> is not allowed.</div>
					<?php
					break;
				}
			}
			?>
			
		<form enctype="multipart/form-data" action="<?php $_PHP_SELF ?>" method="POST" >
			<div class="form-group">
				<input type="file" name="photo" class="form-control" >
			</div>
			<input type="submit" name="uploadPhoto" class="btn" value="Upload Featured Photo" style="background-color: #343a40;">
		</form>
		
	</body>
</html>