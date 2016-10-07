<?php
include_once 'psl-config.php';

//SESSION FUNCTION
function sec_session_start(){
	$session_name='sec_session_id';  // set a custom session name
	$secure=SECURE; //this stops javascript from being able to access the script
	
	$httponly=true; 
	
	//forces session to only use cookies
	if (ini_set('session.use_only_cookies',1)==false){
		header("Location:.../error.php?=Could not initiate a safe session(ini_set)");
		exit();
	}
	
	//gets current cookie params
	$cookieparams=session_get_cookie_params();
	session_set_cookie_params($cookieparams["lifetime"],
	                          $cookieparams["path"],  
	                           $cookieparams["domain"],
							   $secure,
							   $httponly);
							   
	//set cookie name to the one set above
session_name($session_name);
session_start();
session_regenerate_id(true);
	
							   
}

//LOGIN FUNCTION
function login($email,$password,$mysqli){
	//use of preparedstatements to ensure sql injection is impossible
	if($stmt=$mysqli->prepare("SELECT id, username,password,salt FROM 
	members WHERE email=? LIMIT 1")){
		$stmt->bind_param('s',$email); //bind $email to parameter 
		$stmt->execute(); //execute the query
		$stmt->store_result(); 
		
		//get variable from the result
		$stmt->bind_result($user_id,$username,$db_password,$salt);
		$stmt->fetch();
		
		
		//hash the password with a unique salt
		$password=hash('sha512',$password.$salt);
		if ($stmt->num_rows==1){
			/**if the user exists we check if account is locked
			from too many login attempts **/
			if (checkbrute($user_id,$mysqli)==true){
				//ac is locked
				//send an email notifying the user
				
				return false;
			}else{
				
				//check if password in the db match
				//the password the user submitted
				if($db_password==$password){
					//password is correct!
					//get the user_agent string of the user
					$user_browser=$_SERVER['HTTP_USER_AGENT'];
					//xss protectition as we might print this value
					$user_id=preg_replace("/[^0-9]+/","",$userid);
					$_SESSION['user_id']=$user_id;
					
					//xss protectition as we might print this value
					$user_name=preg_replace("/[^a-zA-Z0-9_\-]+/","",$username);
					$_SESSION['username']=$username;
					
					$_SESSION['login_string']=hash('sha512',$password.$user_browser);
					//login successful
					return true;
		
				}else{
					//password is not correct
					//we record this attempt in the database\
					
					$now=time();
					$mysqli->query("INSERT INTO login_attempts(user_id,
					time)VALUES ('$user_id','$now')");
					return false;
				}
				
			}
			
			
		}else{
				//no user exists
				return false;
			}
		
		
	
	
	}
		
}

//BRUTE FORCE CODE

function checkbrute($user_id,$mysqli){
	//get the timestamp of current time
	$now=time();
	
	//all login attempts are counted for the past two hours
	
	$valid_attempts=$now-(2*60*60);
if ($stmt=$mysqli->prepare("SELECT time FROM login attempts 
                           WHERE user_id=? 
						   AND time>'$valid_attempts'")){
		$stmt->bind_param('i',$user_id);
		//execute the prepared query
    	$stmt->execute();
    	$stmt->store_result();
		

		//if there have been more than 5 failed logins
		if($stmt->num_rows>5){
			return true;
		}else{
			return false;
		}	
						  					   
	  }	
		
}

//CHECK LOGIN STATUS
function login_check($mysqli){
	//check if all session variables are set
	if (isset($_SESSION['user_id'],
			  $_SESSION['username'],
			  $_SESSION['login_string'])){
				  
		$user_id=$SESSION['user_id'];
		$login_string=$SESSION['login_string'];
		$username=$SESSION['username'];
		
		//get the user-agent string of the user
		
		$user_browser=$_SERVER['HTTP_USER_AGENT'];
		
		if ($stmt=$mysqli->prepare("SELECT password 
									FROM members WHERE id=? LIMIT 1")){
			//bind "user_id" to parameter
			$stmt->bind_param('i',$user_id);
			$stmt->execute();
			$stmt->store_result();
			
			if($stmt->num_rows==1){
				//if user exits get variable from result
				$stmt->bind_result($password);	
				$stmt->fetch();	
				$login_check=hash('sha512',$password.$user_browser);
					if($login_check==$login_string){
						//logged in!
						return true;
						
					}else{
						//not logged in
						return false;
					}
				
			}else{
				//not logged in
				return false;
			}
			
		}
}}


/**
This  function sanitizes the output from the PHP_SELF server 
variable. It is a modificaton of a function of the same name 
used by the WordPress Content Management System:**/

function esc_url($url){
	if(''==$url){
		return $url;
		
	}
	$url=preg_replace('|[^a-Z0-9~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i','',$url);
	$strip=array('%0d','%0a','%0D','%0A');
	$url=(string)$url;
	
	$count=1;
	while($count){
		$url=str_replace($strip,'',$url,$count);
		
	}
	$url=str_replace(';//','://',$url);
	
	$url=htmlentities($url);
	
	$url=str_replace('&amp;','&#038',$url);
	$url=str_replace("'",'&#039',$url);
	
	if($url[0]!=='/'){
		/**we're only interested in relative links 
		from $_SERVER['PHP_SELF']**/
		return '';
	}else{
		return $url;
	}
}
?>