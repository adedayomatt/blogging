<?php
	require('resources/php/master.php');
?>
<!DOCTYPE html>
<html>
	<head>
	<?php
	$title = "Home";
	require('resources/global/meta-head.php');
	?>
	<style>
	.carousel-item>img{
		height: 500px;
		-webkit-filter: grayscale(70%);
		filter: grayscale(70%);
		-webkit-filter: blur(5px);
		filter: blur(5px);
	}
	.carousel-caption>h1{
		font-size: 80px;
		font-weight: 900;
	}
	.carousel-caption>h3{
		font-size: 50px;
	}
	</style>
	</head>
	<body>
	<?php
	require('resources/global/header.php');
	?>
				<div id="carouselIndicators" class="carousel slide" data-ride="carousel">
				  <ol class="carousel-indicators">
					<li data-target="#carouselIndicators" data-slide-to="0" class="active"></li>
					<li data-target="#carouselIndicators" data-slide-to="1"></li>
					<li data-target="#carouselIndicators" data-slide-to="2"></li>
					<li data-target="#carouselIndicators" data-slide-to="3"></li>
					<li data-target="#carouselIndicators" data-slide-to="4"></li>
				  </ol>
				  <div class="carousel-inner">
					<div class="carousel-item active">
					  <img class="d-block w-100" src="images/gif/giphy-1.gif" alt="The Gists and Gossips are here">
					  <div class="carousel-caption d-none d-md-block">
						<h1>WE SERVE YOU THE GISTS HOT</h1>
						<h3>Just Sit Back and Sip!</h3>
						</div>
					</div>
					<div class="carousel-item">
					  <img class="d-block w-100" src="images/gif/giphy-2.gif" alt="The Gists and Gossips are here">
					  <div class="carousel-caption d-none d-md-block">
						<h1>DON'T BE WOWED</h1>
						<h3>Sh*t Happens!</h3>
						</div>
					</div>
					<div class="carousel-item">
					  <img class="d-block w-100" src="images/gif/giphy-3.gif" alt="The Gists and Gossips are here">
					  <div class="carousel-caption d-none d-md-block">
						<h1>THIS IS WHERE THE GISTS ARE</h1>
						<h3>You Don't Want to Miss Them!</h3>
						</div>
					</div>
					<div class="carousel-item">
					  <img class="d-block w-100" src="images/gif/giphy-4.gif" alt="The Gists and Gossips are here">
					  <div class="carousel-caption d-none d-md-block">
						<h1>YOU JUST CAN'T GET ENOUGH OF OUR PACKAGE</h1>
						<h3>We Keep Giving You the Gossips Back2Back!</h3>
						</div>
					</div>
					<div class="carousel-item">
					  <img class="d-block w-100" src="images/gif/giphy-5.gif" alt="The Gists and Gossips are here">
					  <div class="carousel-caption d-none d-md-block">
						<h1>YOU WANT TO KNOW MORE?</h1>
						<h3>Then Stay With Us!</h3>
						</div>
					</div>
				  </div>
				  <a class="carousel-control-prev" href="#carouselIndicators" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				  </a>
				  <a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				  </a>
				</div>
				<style>
				.blog-post-container{
					margin: 5px 0px;
					border: 1px solid #F7F7F7;
				}
				.blog-post-header{
					padding:5px;
					background-color: #F7F7F7;
					border-bottom: 1px solid  #F7F7F7;
				}
				</style>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
				<div class="section">
					<div class="section-head">
						<h2><i class="fas fa-newspaper"></i>  Latest Gists &amp; Gossips</h2>
					</div>
					<div class="section-body">
					<?php
					$posts = $fetch->getPosts();
					if(count($posts) == 0){
						?>
						<div class="alert alert-warning">
							<i class="fas fa-exclamation-circle"></i>  No Gossip for now, go find some work to do Amebo
						</div>
						<?php
					}
					else{
						$p = 0;
					while($p < count($posts)){
						$post = new POST($posts[$p]);
					?>
						<div class="blog-post-container">
							<div class="blog-post-header">
								<?php
								if($post->featured_photo == true){//If there is any featured photo for the post
									?>
									<img src="<?php echo $post->featured_photo_url ?>" class="post-photo-lg">
									<?php
								}
								?>
								<a class="post-title" href="post/?pid=<?php echo $post->id ?>"><?php echo $post->title ?></a>
								<div>
									<span class="poster">By: <i class="fas fa-user"></i>  <?php echo $post->posterFullName ?> (@<?php echo $post->posterUsername ?>)</span>
									<span class="post-meta"><i class="fas fa-clock"></i>  <?php echo $tool->since($post->timestamp)?></span>
									<span class="post-meta"><i class="fas fa-comment"></i>  <?php echo $post->commentCounts?> </span>
								</div>
							</div>
							<p style="padding: 5px 10px"><?php echo $tool->substring($post->body,'abc',300) ?></p>
							<div class="text-right">
								<a class="btn" href="post/?pid=<?php echo $post->id ?>">Read Full Gist</a>
							</div>
						</div>
					
					<?php
						$p++;
						if($p%4 == 0){//after every 4 posts
						?>
						<div class="text-center">
							<img src="images/gif/giphy-6.gif" width="100%" height="auto">
							<p style="color: grey"><i>When you mistakenly tell your dad to Fuck off!</i></p>
						</div>
						<?php
							}
						}
					}
					?>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			
				<div class="section">
					<div class="section-head">
						<h2><i class="fas fa-comment"></i> Recent Reactions</h2>
						</div>
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
									<p class="post-title"><i class="fas fa-quote-left" style="color:#F7F7F7"></i>  <?php echo $tool->substring($comment->comment, 'abc', 100) ?>  <i class="fas fa-quote-right" style="color:#F7F7F7"></i></p>
									<p class="help-text text-right"> - <i class="fas fa-user"></i><?php echo $comment->commenter.', '.$tool->since($comment->timestamp)  ?> </p>
									<p style="font-size: 14px"><i class="fas fa-newspaper"></i>  On the Post: <a href="../post/?pid=<?php echo $post->id ?>" class="post-title"><?php echo $Cpost->title ?></a></p>
						
								</div>
								<?php
								$cm++;
								}
							}
						?>
					</div>
				</div>

			</div>
		</div>
	</div>
	
	<?php
	require('resources/global/footer.php');
	?>	
	</body>
	</html>