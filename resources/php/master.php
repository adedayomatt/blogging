<?php
/**
*@author: Adedayo Matthew
*@Created: 19th April, 2018
*@Last Modified: 19th, April, 2018.
*This script is intended to have all the classes of different operations so we wouldn't have to much php script to be 
*written in other pages, all we'll do is just to require this script and instantiate the class we need. The idea is to 
*centralized our PHP codes in a single script.
**/

require('global.php'); //import the script where we have some things especilally the database connection is set up already

//This is the class for messages user send to the school management via the website.
class ADMIN{
	private $db; //Make the database connection a private one so it is only accessible in this class 
	public $id;
	public $firstName;
	public $lastName;
	public $fullName;
	public $username;
	public $posts;
	public $dateRegistered;
	public $timestamp;
	public $lastSeen;
	function __construct($id){//The constructor should initiate theb database connection
		$this->db = new database();
		$getAdmin = $this->db->query_object("SELECT * FROM admins WHERE admin_id = '$id'");
		if($getAdmin->rowCount() == 1){
			$a = $getAdmin->fetch(PDO::FETCH_ASSOC);
			$this->id = $a['admin_id'];
			$this->firstName = $a['first_name'];
			$this->lastName = $a['last_name'];
			$this->fullName = $a['first_name'].' '.$a['last_name'];
			$this->username = $a['username'];
			$this->dateRegistered = $a['date_registered'];
			$this->timestamp = $a['timestamp'];
			$this->lastSeen = $a['last_seen'];
			$this->posts = $this->db->query_object("SELECT post_id FROM posts WHERE posted_by = '".$this->id."'")->rowCount();
			return true;
		}
		else{
			return false;
		}
	}
	
	public function welcomeMsg(){
		$name = $this->firstName;
		$msg[0] = "Hello $name, how is it going today?";
		$msg[1] = "$name, we just want to say thank you again for using myBlog";
		$msg[2] = "$name, We've got a feeling, it's going to be a great day!";
		$msg[3] = "Hey $name, Greetings to you from Matthews";
		$msg[4] = "$name, You probably don't know this, we care about YOU!";
		return $msg;
	}
	public function updateLastSeen($lastSeen){
		$this->db->query_object("UPDATE users SET last_seen = $lastSeen");
	}
}

class POST{
	private $db;
	
	public $id;
	public $title;
	public $body;
	public $featured_photo;
	public $featured_photo_url;
	public $posterId;
	public $posterFullName;
	public $posterUsername;
	public $datePosted;
	public $timestamp;
	public $commentCounts;
	public $commentsId = array();
	
	function __construct($id){
		$this->db = new database();
		$getPost = $this->db->query_object("SELECT * FROM posts WHERE post_id = '$id'");
		if($getPost->rowCount() == 1){
			$post = $getPost->fetch(PDO::FETCH_ASSOC);
			$this->id = $post['post_id'];
			$this->title = $post['title'];
			$this->body = $post['body'];
			$this->featured_photo = ($post['featured_photo'] == '' ? false : true);//check if there is featured photo for the post
			$this->featured_photo_url = SITE::$root.'/images/featured-photos/'.$post['featured_photo'];
			$this->posterId = $post['posted_by'];
			$this->datePosted = $post['date_posted'];
			$this->timestamp = $post['timestamp'];
			
			//Get associated comments
			$c = 0;
			$getComments = $this->db->query_object("SELECT comment_id FROM comments WHERE post_id = '$id'");
			if($getComments->rowCount() > 0){// if any comment is found for the post
				while($comment = $getComments->fetch(PDO::FETCH_ASSOC)){
					$this->commentsId[$c] = $comment['comment_id'];
					$c++;
				}
			}
			$this->commentCounts = count($this->commentsId);
			$poster = new ADMIN($this->posterId);
			$this->posterFullName = $poster->fullName;
			$this->posterUsername = $poster->username;
		}
	}
	
	public function deletePost(){
		if($this->db->query_object("DELETE FROM posts WHERE post_id = ".$this->id."")->rowCount() == 1){
			return true;
	}
	else{
		return false;
		}
	}
}

class COMMENT{
	private $db;
	public $id;
	public $postId;
	public $comment;
	public $commenter;
	public $dateCommented;
	public $timestamp;
	
	function __construct($id){
		$this->db = new database();
		$getComment = $this->db->query_object("SELECT * FROM comments WHERE comment_id = '$id'");
		if($getComment->rowCount() == 1){
			$comment = $getComment->fetch(PDO::FETCH_ASSOC);
			$this->id = $comment['comment_id'];
			$this->postId = $comment['post_id'];
			$this->comment = $comment['comment'];
			$this->commenter = $comment['commenter'];
			$this->dateCommented = $comment['date_commented'];
			$this->timestamp = $comment['timestamp'];
			
			//Get associated comments
		}
	}
	
	public function deleteComment(){
		if($this->db->query_object("DELETE FROM comments WHERE comment_id = ".$this->id."")->rowCount() == 1){
			return true;
	}
	else{
		return false;
		}
	}
	
}


class LOGIN{
	private $db;
	private $credentials;
	
	function __construct($input){
		 $this->db = new database();//initiate the database connection
		 $this->credentials = $input;
	}

	public function verify(){
		$loginReport = 999;
		$username = $this->credentials['username'];
		$password = $this->credentials['password'];
		$passwordHash = SHA1($this->credentials['password']);
		$stayLoggedIn = $this->credentials['stay_logged_in'];
		
		$getUsername = $this->db->query_object("SELECT admin_id,password,password_hash,token FROM admins WHERE username = '$username'");
		if($getUsername->rowCount() == 1){
			$db_credentials = $getUsername->fetch(PDO::FETCH_ASSOC);
			if($db_credentials['password'] == $password && $db_credentials['password_hash'] == $passwordHash){
				$loginReport = 000;//Login successful
				if($stayLoggedIn == 1){
				setcookie('myBlog',$db_credentials['token'], time()+(86400 * 30),'/'); // The user token is used to remember returning user, the cookie expires in 30 days if user chooses to remained logged in; 
				}
				else if($stayLoggedIn == 0){
				setcookie('myBlog',$db_credentials['token'],0,'/'); // log out when browser session ends
				}
			}
			else{
				$loginReport = 101;// Incorrect password
			}
		}
		else{
			$loginReport = 102; // username does not exist
		}
		return $loginReport;
	}
}

class NEWDATA{
	private $db;
	
	function __construct(){
		$this->db = new database();
	}
	public function newAdmin($inputs){
		if($this->db->query_object("SELECT username FROM admins WHERE username = '".$inputs['username']."'")->rowCount() != 0){//check if the username is taken already
			return 111;
		}else{
			$query = "INSERT INTO admins (admin_id,first_name,last_name,username,password,password_hash,date_registered,timestamp,last_seen,token)
						VALUES (:id,:fname,:lname,:uname,:password,:passwordHash,NOW(),:time,:lastSeen,:token)";
			$timestamp = time();
			$adminId = "admin-$timestamp";
			$stmt = $this->db->prepare_statement($query);
			$stmt->bindValue(':id', $adminId, PDO::PARAM_STR);
			$stmt->bindValue(':fname', $inputs['first_name'], PDO::PARAM_STR);
			$stmt->bindValue(':lname', $inputs['last_name'], PDO::PARAM_STR);
			$stmt->bindValue(':uname', $inputs['username'], PDO::PARAM_STR);
			$stmt->bindValue(':password', $inputs['password'], PDO::PARAM_STR);
			$stmt->bindValue(':passwordHash', SHA1($inputs['password']), PDO::PARAM_STR);
			$stmt->bindValue(':time', $timestamp, PDO::PARAM_INT);
			$stmt->bindValue(':lastSeen', $timestamp, PDO::PARAM_INT);
			$stmt->bindValue(':token', SHA1(MD5($inputs['password'])), PDO::PARAM_INT);
			$stmt->execute();
			if($stmt->rowCount() == 1){
				return 000; //
			}
			else{
				return 999;
			}
		}
	}

	public function newPost($inputs){
		$query = "INSERT INTO posts (post_id,title,body,featured_photo,posted_by,date_posted,timestamp) 
					VALUES (:id,:title,:body,:photo,:poster,NOW(),:time)";
		$timestamp = time();
		$photo = (isset($_COOKIE['fp']) ? $_COOKIE['fp'] : '');// retrieve the featured photo from the cookie
		$postId = "post-$timestamp";
		$stmt = $this->db->prepare_statement($query);
		$stmt->bindValue(':id', $postId, PDO::PARAM_STR);
		$stmt->bindValue(':title', $inputs['title'], PDO::PARAM_STR);
		$stmt->bindValue(':body', $inputs['body'], PDO::PARAM_STR);
		$stmt->bindValue(':photo', $photo, PDO::PARAM_STR);
		$stmt->bindValue(':poster', $inputs['poster'], PDO::PARAM_STR);
		$stmt->bindValue(':time', $timestamp, PDO::PARAM_STR);
		$stmt->execute();
		if($stmt->rowCount() == 1){
			setcookie('fp','',time()-3600,'/'); //clear the picture cookie if there was any at all
			return true;
		}
		else{
			return false;
		}
	}

	public function newComment($inputs){
		$query = "INSERT INTO comments (comment_id,post_id,comment,commenter,date_commented,timestamp) 
					VALUES (:cid,:pid,:comment,:commenter,NOW(),:time)";
		$timestamp = time();
		$commentId = "comment-$timestamp";
		$stmt = $this->db->prepare_statement($query);
		$stmt->bindValue(':cid', $commentId, PDO::PARAM_STR);
		$stmt->bindValue(':pid', $inputs['post_id'], PDO::PARAM_STR);
		$stmt->bindValue(':comment', $inputs['comment'], PDO::PARAM_STR);
		$stmt->bindValue(':commenter', $inputs['commenter'], PDO::PARAM_STR);
		$stmt->bindValue(':time', $timestamp, PDO::PARAM_STR);
		$stmt->execute();
		if($stmt->rowCount() == 1){
			return true;
		}
		else{
			return false;
		}
	}

	
}
class GETDATA{
	private $db;
	
	function __construct(){
		$this->db = new database();
	}
	function getPosts(){//get $n number of most recent posts
		$postId = array();
		$i = 0;
		$getP = $this->db->query_object("SELECT post_id FROM posts ORDER BY timestamp DESC");
		while($p = $getP->fetch(PDO::FETCH_ASSOC)){
			$postId[$i] = $p['post_id'];
			$i++;
		}
		return $postId;
	}
	
	function getComments(){//get $n number of most recent posts
		$commentId = array();
		$i = 0;
		$getC = $this->db->query_object("SELECT comment_id FROM comments ORDER BY timestamp DESC");
		while($p = $getC->fetch(PDO::FETCH_ASSOC)){
			$commentId[$i] = $p['comment_id'];
			$i++;
		}
		return $commentId;
	}
	function getAdmins(){//get $n number of most recent posts
		$adminId = array();
		$i = 0;
		$getA = $this->db->query_object("SELECT admin_id FROM admins ORDER BY timestamp");
		while($a = $getA->fetch(PDO::FETCH_ASSOC)){
			$adminId[$i] = $a['admin_id'];
			$i++;
		}
		return $adminId;
	}
	
}

class Verification{
	private $db;
	function __construct(){
		 $this->db = new database();//initiate the database connection
	}
	//This is to verify if a user is logged on every page, it uses the COOKIE that was set at loggin to verify the user
	public function verifyAdmin(){
		$adminStatus = null;
		if(isset($_COOKIE['myBlog'])){
			$token = $_COOKIE['myBlog'];
			$checkAdminToken = $this->db->query_object("SELECT admin_id FROM admins WHERE token = '$token'");
			if($checkAdminToken->rowCount() == 1){
				$a = $checkAdminToken->fetch(PDO::FETCH_ASSOC); //return the user id
				$adminStatus = $a['admin_id'];
			}
		}
		return $adminStatus;
	}
}

 //Verification on page load
 $verify = new Verification();
$status = $verify->verifyAdmin();
if($status == null){
		$admin = null;
}
else{
	$admin = new ADMIN($status); //Create an object for the user logged in
}

//initiate some objects
$tool = new Tool();
$put = new NEWDATA();
$fetch = new GETDATA();

//echo $status."<br/>";
?>