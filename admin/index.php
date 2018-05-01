<?php
	require('../resources/php/master.php');
	if($status == null){
		$tool->redirect_to("login.php?_rdr=".SITE::currentURL());
	}
	if(isset($_POST['post'])){
		$new = new NEWDATA();
	if($new->newPost($_POST)){
			$postReport = "Your post has been published";
			$posted = true;
		}
		else{
			$postReport = "Your post was not published";
			$posted = false;
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
	<?php
	$title = "Admin";
	require('../resources/global/meta-head.php');
	?>
	<style>
	.welcome-msg-container{
		background-color: #FFF;
		padding: 5px;
		border: 1px solid #e3e3e3;
		border-radius: 3px;
		margin: 10px 0px;
	}
	iframe{
		width: 80%;
		height: auto;
		min-height: 200px;
		margin: 5px 10%;
	}
	</style>
	</head>
	<body>
	<?php
	require('../resources/global/header.php');
	?>
	<div class="container-fluid">
		<div class="row">
		
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="welcome-msg-container text-center">
				<h4><i class="fas fa-smile" style="font-size: 40px; color:rgba(52, 100, 64, 1)"></i>  <?php echo (time() - $admin->lastSeen >= 86400 * 5 ? $admin->firstName.", quite a while now, we miss you here" : $admin->welcomeMsg()[rand(0,4)]) ?></h4>
				</div>
			</div>

			<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
				<div class="section">
					<div class="section-head"><i class="fas fa-plus"></i>  New Post</div>
					<div class="section-body">
						<?php
						if(isset($postReport) && isset($posted)){
							
							?>
							<div class="alert text-center <?php echo ($posted == true ? 'alert-success' : 'alert-danger')?>" role="alert">
								<i class="fas <?php echo ($posted == true ? 'fa-check-circle' : 'fa-times-circle')?>"></i>  <?php echo $postReport ?>
							</div>
							<?php
						}
						?>
						<form action="<?php $_PHP_SELF ?>" method="POST">
							<input type="hidden" name="poster" value="<?php echo $admin->id ?>">
							<div class="form-group">
								<label><i class="fas fa-pencil-alt light-green"></i>  Post Title</label>
								<p class="help-text">Give your post an interesting title, visitors are more thrilled with catching titles</p>
								<input type="text" name="title" class="form-control" placeholder="What is title of your post?" value="<?php echo (isset($_POST['title']) ? $_POST['title'] : '' ) ?>" required>
							</div>

							<div class="form-group">
								<label><i class="fas fa-pencil-alt light-green"></i>  Body</label>
								<textarea cols="5" rows="4" name="body" class="form-control" placeholder="Content of your post" required><?php echo (isset($_POST['body']) ? $_POST['body'] : '' ) ?></textarea>
							</div>
							<div class="form-group">
								<label><i class="fas fa-images light-green"></i>  Featured Photo <span style="color: grey; font-size: 80%"><i>(Optional)</i></span></label>
								<?php
								$now = time();
								$fp = "featured-photo-$now";
								?>
								<input type="hidden" name="photo" value="<?php echo $fp ?>">
								<iframe src="fp.php?photo=<?php echo $fp ?>" frameborder="0"></iframe>
							</div>
							<input type="submit" name="post" class="btn btn-lg" value="Publish">
						</form>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"  style="height: 120vh; overflow-y: auto">
				<!--Recent Posts-->
				<div class="section">
					<div class="section-head"><i class="fas fa-newspaper"></i> Recent Posts</div>
					<div class="section-body">
						<?php
							$recentPosts = $fetch->getPosts();
							if(count($recentPosts) == 0){
								?>
								<div class="alert alert-warning text-center" role="alert">
								<i class="fas fa-exclamation-circle"></i>  No Posts for now
								</div>
								<?php
							}
							else{
								$rp = 0;
								while($rp < count($recentPosts)){
									if($rp == 5){ //only show 5 recent posts
										break;
									}
									$post = new POST($recentPosts[$rp]);
								?>
								<div class="recent-post-container" style="border-bottom: 1px solid #e3e3e3">
									<?php
									if($post->featured_photo == true){//If there is any featured photo for the post
										?>
										<img src="<?php echo $post->featured_photo_url ?>" class="post-photo-xs">
										<?php
									}
									?>
									<a href="../post/?pid=<?php echo $post->id ?>" class="post-title"><?php echo $tool->substring($post->title, 'abc', 30) ?></a>
									<div>
										<span class="poster">By: <i class="fas fa-user"></i>  <?php echo $post->posterFullName ?> (@<?php echo $post->posterUsername ?>)</span><br/>
										<span class="post-meta"><i class="fas fa-clock"></i>  <?php echo $tool->since($post->timestamp)?></span>
										<span class="post-meta"><i class="fas fa-comment"></i>  <?php echo $post->commentCounts?> </span>
									</div>
									<div style="background-color: #f9f9f9; padding: 5px; margin: 5px; border-radius: 3px;">
										<p class="post-body"><?php echo $tool->substring($post->body, 'abc', 150) ?></p>
									</div>
								</div>
								<?php
								$rp++;
								}
							}
						?>
					</div>
				</div>
				<!--Recents Comments-->
				<div class="section">
					<div class="section-head"><i class="fas fa-comment"></i> Recent Comments</div>
					<div class="section-body">
						<?php
							$recentComments = $fetch->getComments();
							if(count($recentComments) == 0){
								?>
								<div class="alert alert-warning text-center" role="alert">
								<i class="fas fa-exclamation-circle"></i>  No Comments for now
								</div>
								<?php
							}
							else{
								$cm = 0;
								while($cm < count($recentComments)){
									if($cm == 5){ //only show 5 recent posts
										break;
									}
									$comment = new COMMENT($recentComments[$cm]);
									$Cpost = new POST($comment->postId); //The post object
								?>
								<div class="recent-comment-container" style="border-bottom: 1px solid #e3e3e3">
									<p><i class="fas fa-quote-left" style="color: #F7F7F7"></i>  <?php echo $tool->substring($comment->comment, 'abc', 100) ?>  <i class="fas fa-quote-right" style="color: #F7F7F7"></i></p>
									<p class="help-text text-right" style="color: grey"> - <i class="fas fa-user"></i><?php echo $comment->commenter.', '.$tool->since($comment->timestamp)  ?> </p>
									<p><i class="fas fa-newspaper"></i>  On the Post: <a href="../post/?pid=<?php echo $post->id ?>" class="post-title"><?php echo $Cpost->title ?></a></p>
						
								</div>
								<?php
								$cm++;
								}
							}
						?>
					</div>
				</div>	
				<!--Admins-->
				<div class="section">
					<div class="section-head"><i class="fas fa-user"></i>  Admins</div>
					<div class="section-body">
					<?php
							$admins = $fetch->getAdmins();
							if(count($admins) == 0){
								?>
								<div class="alert alert-warning text-center" role="alert">
								<i class="fas fa-exclamation-circle"></i>  There are no Admins
								</div>
								<?php
							}
							else{
								$ad = 0;
								?>
								<style>
									.admin-list{
										border-bottom: 1px solid #e3e3e3;
										padding: 5px;
									}
									.admin-list.current-admin{
										color: rgba(52, 200, 64, 1);
										font-weight: bold;
									}
									.admin-list>span.help-text{
										margin: 5px;
									}
								</style>
								<?php
								while($ad < count($admins)){
									$_admin = new ADMIN($admins[$ad]);
								?>
								<div class="admin-list <?php echo ($_admin->id == $admin->id ? 'current-admin' : '') ?>">
									<p><i class="fas fa-user"></i> <?php echo $_admin->fullName."<span class=\"username\">(@".$_admin->username.")" ?></p> 
									<span class="help-text"><i class="fas fa-newspaper"></i>  Posts: <?php echo $_admin->posts ?></span>
									<?php
									if($_admin->id != $admin->id ){
									?>
									<span class="help-text"><i class="fas fa-clock"></i>  Registered: <?php echo $tool->since($_admin->timestamp) ?></span>
									<span class="help-text"><i class="fas fa-clock"></i>  Last Seen: <?php echo $tool->since($_admin->lastSeen) ?></span>
									<?php
									}
									?>
								</div>
								<?php
								$ad++;
								}
							}
							?>
					</div>
				</div>
			</div>
		</div>
	
	<?php
	require('../resources/global/footer.php');
	?>	</body>
</html>