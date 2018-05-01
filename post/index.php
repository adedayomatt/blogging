<?php
	require('../resources/php/master.php');
	$post = null;
	if(isset($_GET['pid'])){
		$postId = $_GET['pid'];
		$post = new POST($postId);
		if($post->id == ''){//if the post id does not exist
			$post = null;
		}
	}
	//If a comment is submitted
	if(isset($_POST['submit_comment'])){
		if($_POST['comment'] != ''){ //if submitted comment is not empty
			function clean_comment($input){
				return trim(htmlentities($input));
			}
			$commenter = clean_comment($_POST['commenter']);
			$commenterId = ($commenter == '' ? 'Anonymous' : $commenter);
			$comment = clean_comment($_POST['comment']);
			$postId = $_POST['pid'];
			
			$commentArray = array('pid'=>$postId,'commenter'=>$commenterId,'comment'=>$comment,'post_id'=>$postId);
			if($put->newComment($commentArray)){
				$commented = true;
				$commentReport = "$commenterId, Your comment have been published";
			}
			else{
				$commented = false;
				$commentReport = "$commenterId, Your comment was unable to be published";
			}
		}
		else{
				$commented = false;
				$commentReport = "Hey ".($commenterId == 'Anonymous' ? '' : "$commenterId").", we cannot publish an empty comment, please write something";
		}
		$post = new POST($postId);// Re-instantiate the post object so it get updated
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<?php
		$title = (isset($post->title) ? $post->title : 'No Post Here');
		require('../resources/global/meta-head.php');
		?>
		<style>
		.post-title{
			color: rgba(52, 200, 64, 1);
		}
		.comment-wrapper{
			padding: 5px;
			background-color: #F7F7F7;
			border-radius: 5px;
			margin-bottom: 5px;
		}
		</style>
	<head>
	<body>
	<?php
		require('../resources/global/header.php');
	?>
	
	<div class="container-fluid">
		<div class="row">
			<?php
			if($post == null){
				?>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="section">
					<div class="alert-warning text-center" style="padding: 20px">
						<h1><i class="fas fa-exclamation-circle"></i>  We can't find any post here</h1>
					</div>
				</div>
			</div>
				<?php
			}else{
			?>
			<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
				<div class="section">
					<div class="section-body">
						<?php
								if($post->featured_photo == true){//If there is any featured photo for the post
									?>
									<div class="text-center">
										<img src="<?php echo $post->featured_photo_url ?>" class="post-photo-super">
									</div>
									<?php
								}
								?>
						<h4 class="post-title"><?php echo $post->title ?></h4>
						<p class="poster">By: <i class="fas fa-user"></i>  <?php echo $post->posterFullName ?> (@<?php echo $post->posterUsername ?>)</p>
						<div class="text-right">
							<span class="post-meta"><i class="fas fa-clock"></i>  <?php echo $tool->since($post->timestamp)?></span>
						</div>
						<p><?php echo $post->body ?></p>
					</div>
				</div>
				<!--Comment area-->
				<div class="section" id="comments">
					<div class="section-head">
						<h5><i class="fas fa-comment"></i>   Comments</h5>
					</div>
					<div class="section-body">
					<?php 
					$postComments = $post->commentsId;
					if(count($postComments) == 0){
						?>
						<div class="alert alert-warning text-center">
							There is no comment on this post <strong>"<?php echo $post->title ?>"</strong> yet.<br/>
							Be the first to comment
						</div>
						<?php
						}
						else{
							$c = 0;
							while($c < count($postComments)){
								$comment = new COMMENT($postComments[$c]);
								?>
								<div class="comment-wrapper">
									<div style="color: grey">
										<span><i class="fas fa-user"></i>  <?php echo $comment->commenter ?></span> 
										<span class="help-text" style="margin-left: 10px;"><i class="fas fa-clock"></i>  <?php echo $comment->dateCommented.', '.$tool->since($comment->timestamp) ?></span>
									</div>
									<p><?php echo $comment->comment ?></p>
									
								</div>
								<?php
								$c++;
							}
						}
					?>
					<h5>Leave Your Comment</h5>
					<p class="help-text">Share with others what you think about this post <strong>"<?php echo $post->title ?>"</strong></p>
					<?php
					if(isset($commented) && isset($commentReport)){
						?>
						<div class="alert <?php echo (($commented) ? 'alert-success' : 'alert-danger') ?>">
							<i class="fas <?php echo (($commented) ? 'fa-check-circle' : 'fa-times-circle') ?>"></i>  <?php echo $commentReport ?>
						</div>
						<?php
					}
					?>
					<form action="#comments" method="POST">
						<input type="hidden" name="pid" value="<?php echo $post->id ?>">
						<div class="form-group">
							<label><i class="fas fa-user"></i>  Your Name</label>
							<p class="help-text">Let's know atleast your name</p>
							<input type="text" name="commenter" class="form-control" placeholder="Enter your name here" value="<?php echo (isset($_POST['commenter']) ? $_POST['commenter'] : ($status != null ? $admin->fullName : ''))?>">
						</div>
						
						<div class="form-group">
							<label><i class="fas fa-comment"></i>  Your Comment</label>
							<textarea cols="5" rows="4" name="comment" class="form-control" placeholder="Type your thoughts on '<?php echo $post->title ?>' here"><?php echo (isset($_POST['comment']) && isset($commented) && !$commented ? $_POST['comment'] : '') ?></textarea>
						</div>
						<input type="submit" class="btn" name="submit_comment" value="Submit Comment" >
					</form>
					
					</div>
				</div>
			</div>
			
			<div class="col-lg-4 col-md-8 col-sm-4 col-xs-12">
				<div class="section">
					<div class="section-head">
						<h2><i class="fas fa-newspaper"></i>  Other Posts</h2>
					</div>
					<div class="section-body">
						<div class="section-body">
							<?php
								$otherPosts = $fetch->getPosts();
								if(count($otherPosts) == 0){
									?>
									<div class="alert alert-warning text-center" role="alert">
									<i class="fas fa-exclamation-circle"></i>  No Other Posts
									</div>
									<?php
								}
								else{
									$op = 0;
									while($op < count($otherPosts)){
										if($op == 5){ //only show 5 recent posts
											break;
										}
										$Opost = new POST($otherPosts[$op]);
										
										if($post->id != $Opost->id){
									?>
									<div class="other-post-container" style="border-bottom: 1px solid #e3e3e3">
											<?php
										if($Opost->featured_photo == true){//If there is any featured photo for the post
											?>
												<img src="<?php echo $Opost->featured_photo_url ?>" class="post-photo-sm">
											<?php
										}
										?>
										<a href="../post/?pid=<?php echo $Opost->id ?>" class="post-title"><?php echo $tool->substring($Opost->title, 'abc', 30) ?></a>
										<div>
											<span class="poster">By: <i class="fas fa-user"></i>  <?php echo $Opost->posterFullName ?> (@<?php echo $Opost->posterUsername ?>)</span><br/>
											<span class="post-meta"><i class="fas fa-clock"></i>  <?php echo $tool->since($Opost->timestamp)?></span>
											<span class="post-meta"><i class="fas fa-comment"></i>  <?php echo $Opost->commentCounts?> </span>
										</div>
										<div style="background-color: #f9f9f9; padding: 5px; margin: 5px; border-radius: 3px;">
											<p class="post-body"><?php echo $tool->substring($Opost->body, 'abc', 150) ?></p>
										</div>
									</div>
									<?php
										}
									$op++;
									}
								}
							?>
						</div>
					</div>
				</div>
			</div>
			<?php
			}
			?>
		</div>
	</div>
			<?php
	require('../resources/global/footer.php');
	?>	
	</body>
</html>
