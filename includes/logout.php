<?php
/**logout script 
  starts the session, destroys it and then redirects
  to somewhere else**/
  include_once 'functions.php';
  
  sec_session_start();
  
  //unset all session values
  $_SESSION=array();
  
  //get session parameters
  $params=session_get_cookie_params();
  
  //delete the actual cookie
  setcookie(session_name(),'',time()-42000,
			$params["path"],				
			$params["domain"],				
			$params["secure"],				
			$params["httponly"]);
/**THE ROOT DIRECTORY IS THE WEBSITE eg globalstylings, FOLDER CREATED IN HTDOCS
FOLDER
**/
//destroy session
session_destroy();
header('Location:../index.php');			



?>