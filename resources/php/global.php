<?php
/**
*@author: Adedayo Matthew
*@Created: January, 2017
*@Last Modified: 19th, April, 2018.
*PHP script to get things set for other script. This script has to be required first on every php script if you want 
*to make use of it's classes and especially if you want proper error reporting for debugging
**/

/*Defining what errors are reported and how there are reported.*/
error_reporting( E_ALL | E_ERROR | E_STRICT | E_PARSE);
function handleError($e_no, $e_str,$e_file,$e_line){
$errorLog = "
SCRIPT ERROR: 

Error code: [$e_no] 

Technical Message: $e_str 

File: $e_file 

Line: $e_line 

Page Accessing: ".$_SERVER['PHP_SELF'];
$error = new pageError();
$error->report_error(Tool::error_message(),$errorLog,__FILE__,__CLASS__,__FUNCTION__,__LINE__);
    }
	
set_error_handler("handleError");//Let the function handleError() handles errors. NOTE that, this might not handle fatal error and parse error, atleast i got that from experience with this script

class SITE{
	/**Some basic configuration to make things set**/
	static $root = "http://localhost/myBlog";
	static $dbHost = "localhost";
	static $dbUser = "adedayo";
	static $dbPassword = "matthew";
	static $dbName = "myBlog";
	static $errorLogPath = "admin/logs/error";

	/**Return path of the doument root */
	static function docRoot(){
		return $_SERVER['DOCUMENT_ROOT'];
	}
	/**Returns the script currently running */
	static function currentScript(){
		return $_SERVER['PHP_SELF'];
	}
	/**Returns the current URL and the requests attached to it */
	static function currentURL(){
		return 'http://localhost'.$_SERVER['REQUEST_URI'];
		}
	}

class database{
	static $connection = null;//initialize the connection to be null, the constructor will empower it with the connection object
	
	/*This is the constructor, the database connection is made here*/
	function __construct(){
		$host = SITE::$dbHost;
		$db = SITE::$dbName;
		$user = SITE::$dbUser;
		$password = SITE::$dbPassword;
		
		try{
		database::$connection = new PDO("mysql:host=$host;dbname=$db", $user, $password);
		//echo "PDO connection successful!";
		}
		catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
				$er = new pageError();
				$er->report_error(Tool::error_message(),'CONNECTION ERROR: '.$e->getMessage(),__FILE__,__CLASS__,__FUNCTION__,__LINE__);
				die();

		}
	}
	
/*This function is to run MySQL query, it returns the query object if not Exception is thrown, else it catches the Exception*/
	public function query_object($query){
		if(database::$connection != null){
			try{
				$obj = database::$connection->query($query);
				return $obj;
			}
			catch (PDOException $e) {
				echo 'Query failed: ' . $e->getMessage();
				$er = new pageError();
				$er->report_error(Tool::error_message(),'QUERY ERROR: '.$e->getMessage(),__FILE__,__CLASS__,__FUNCTION__,__LINE__);
				die();
			}
		}
	}
/*This function is to prepare MySQL query, it returns the prepared query object if not Exception is thrown, else it catches the Exception*/
public function prepare_statement($statement){
	try{
			$obj = database::$connection->prepare($statement);
			return $obj;
	}
	catch (PDOException $e) {
				echo 'Query Preparation Failed failed: ' . $e->getMessage();
				$er = new pageError();
				$er->report_error(Tool::error_message(),'QUERY ERROR: '.$e->getMessage(),__FILE__,__CLASS__,__FUNCTION__,__LINE__);
				die();
			}
	
}

/*This function closes the the database connection by setting the connection object to null*/
	public function close(){
		database::$connection = null;
	}

}


class Tool{
	static $OneDay = 86400;
	
	static function no_connection_page(){
		$page = "
			<html>
				<head>
					<title>Connection failed!</title>
				</head>
				<body style=\"background-color:#20435C;\">
					<div style=\"padding:10%; line-height:25px;color:white; text-align:center\">
						<h2 align=\"center\">No Connection to Server</h2>
						<p align=\"center\">Connection to the server could not be established. We are sorry for any inconviniency this might bring you and please be assured that we are working hard to resolve it soon</p>
					</div>
				</body>
			</html>
			";
		return $page;
    }
	
	static function unavailable_page(){
		$page = "
			<html>
				<head>
					<title>Page not Available!</title>
				</head>
				<body style=\"background-color:#20435C;\">
					<div style=\"padding:1%; width:70%;margin:auto; line-height:25px; background-color:white; color:#20435C;border-radius:5px\">
						<h2 align=\"center\">Page temporarily not available.</h2>
						<p align=\"center\">This page you are trying to view is temporarily not available, it may be under maintainance. We are sorry for any inconviniency this might bring you. You can <a href=\"$root\">visit our homepage</a></p>
					</div>
				</body>
			</html>
			";
		return $page;
	}
	
	/*Mesage to display on encountering error*/
	static function error_message(){
		$msg = "
			<div style=\"background-color:white; color:red; width:90%;margin:5% auto;padding:20px;text-align:center; border:1px solid #e3e3e3;border-radius:5px;\">
				<h1> Ooops! Looks like something went wrong!</h1>
				<p>A problem has been encountered while loading this page,
				this error has been logged and please be assured that we'll get it fixed soon.</p>
			</div>
		";
		return $msg;
	}
	
/*This function convert timestamp to relatable time period*/	
	public function since($timestamp){
		$time = time() - $timestamp;
			if($time<60){
				$since = $time.'sec ago';
			}
			else if($time>=60 && $time<3600){
				$since = round(($time/60)).'min ago';
			}
			else if($time>=3600 && $time<86400){
				$since = round(($time/3600)).'h, '.(($time/60)%60).'min ago';
			}
			else if($time>=86400 && $time<604800){
				$since = round(($time/86400)).'d ago, '.date('l, M d ',$timestamp);
			}
			else if($time>=604800 && $time<18144000){
				$since =round(($time/604800)).'wk ago, '.date('M d  ',$timestamp);
			}
			else{
				$since = "invalid time";
			}
		return $since;
	}
		
/*This function helps to strip strings. The first argument takes the string you want to strip, second arguement is how you want to strip the 
string, 'abc' returns the the first $length(the third argument) characters of the string, 'xyz' return the last $length character of the string, while 'abcxyz' the first 
($length/2) characters of the string and the last ($length/2) characters of the string*/		
	public function substring($string,$beginningOrEnd,$length){
		if($beginningOrEnd == 'abc'){
			//return the first $length substring
			return (strlen($string) >= $length ? substr($string,0,$length).'...' : $string);
		}
		else if($beginningOrEnd == 'xyz'){
			//return the last $length substring
			return (strlen($string)>=$length ? '...'.substr($string,(strlen($string)-$length),strlen($string)) : $string);
		}
		else if($beginningOrEnd == 'abcxyz'){
			//return the part of the beginning substring and part of ending substring
			return (strlen($string)>=$length ? substr($string,0,($length/2)).'...'.substr($string,strlen($string)-($length/2),strlen($string)) : $string);
		}
	}
	
	
	public function clean_input($input){
		//return database::$connection->real_escape_string(trim(htmlentities($input)));
		return trim(htmlentities($input));
	}
	
/*This function is just to halt the script currently runnning*/
	public function halt_page(){
			database::$connection = null;
			echo "<pre>page halted!</pre>";
			die();
	}
	
/*This function return the number of "../" to take you back to the root folder. This is useful if you want to use an absolute URL*/	
	public function relative_url(){
		$rel = "";
		$i = 2;
		while($i < substr_count($_SERVER['PHP_SELF'],'/')){
			$rel .= '../';
			$i++;
		}
		return $rel;
	}
	
/*You can easily call this function to redirect via header, it exist the script and set the db conectio to null*/	
	public function redirect_to($url){
		$goto = ($url=='home' ? SITE::$root : $url);
		database::$connection = null;
		header("location: $goto");
		die();
	}	
}


/**This class is for error handling and logging the error for debugging**/
class pageError{
	public function report_error($feedback,$msg,$file,$class,$function,$line){
		echo $feedback;
        $errorLog = "*** error: 
		$msg 
		Reported From: [$file >> $class :: $function >> at line $line] ***";
		$this->logError($errorLog);
	}
	
	public function logError($e){
		$tool = new Tool();
		$logFile = $tool->relative_url().SITE::$errorLogPath.'/error_log_'.time().'.txt';
		$file = fopen($logFile,"a+");
		$error = '['.date('Y : m : d : H : i : s',time()).'] 
	
		'.$e;
		if(fwrite($file,$error)){
			echo "<pre>error logged!</pre>";
		}else{
			echo "<pre>error not logged!</pre>";
		}
		fclose($file);
	
		if(file_exists($logFile)){
			echo "<pre>error has been reported!</pre>";
		}
		else{
			echo "<pre>Error not reported</pre>";
		}
		$tool = new Tool();
		$tool->halt_page();
	}
}





