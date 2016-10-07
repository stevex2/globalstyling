<?php
include_once 'db_connect.php';
include_once 'psl-config.php';

$error_msg="";

if (isset($_POST['username'],$_POST['email'],$_POST['p'])){
	//sanitize and validate data passed in
	
		$username=filter_input(INPUT_POST,'username',FILTER_SANITIZE_STRING);
		$email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
		$email=filter_var($email,FILTER_VALIDATE_EMAIL);
	
	   if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
		//not a valid email
		$error_msg .='<p class="error">The email address you entered is not valid</p>';
	   }
	   $password=filter_input(INPUT_POST,'p',FILTER_SANITIZE_STRING);
	      if(strlen($password)!=128){
		 //hashed pwd should be 128 characters long
		 //if its not its very wierd
		 $error_msg .='<p class="error">Invalid password configuration</p>';
		 
	     }  
		//username and password validity have been checked clientside
		//should be enough as theres no point breaking these rules
		//check existing email
		$prep_stmt="SELECT id FROM members WHERE email=? LIMIT 1";
		$stmt=$mysqli->prepare($prep_stmt);
	
	  if ($stmt){
		 $stmt->bind_param('s',$email);
		 $stmt->execute();
		 $stmt->store_result();
	
	     if($stmt->num_rows==1){
		 //a user with this email already exists
		 $error_msg .='<p class="error">A user with this password already exists</p>';
         $stmt->close();
						
	     }
	     $stmt->close();
	  }   else{
		$error_msg .= '<p class="error">Database error line 44</p>';
		$stmt->close();
	  } 
	
	 //check existing username
		$prep_stmt="SELECT id FROM members WHERE username=? LIMIT 1";
	    $stmt=$mysqli->prepare($prep_stmt);
	
	if ($stmt){
		$stmt->bind_param('s',$username);
		$stmt->execute();
		$stmt->store_result();
	
	    if($stmt->num_rows==1){
		//a user with this email already exists
		$error_msg .='<p class="error">A user with this username already exists</p>';
        $stmt->close();
						
	    }
	 $stmt->close();
	} else{
		$error_msg .= '<p class="error">Database error line 65</p>';
		$stmt->close();
	}
	
	  //we also have to check the type of user attempting to register to ensure
	  //users eithout sufficient rights dont register
	 if(empty($error_msg)){
		//create a random salt
		//$random_salt=hash('',uniqid(openssl_random_pseudo_bytes(16),TRUE)); didnt work
		$random_salt=hash('sha512',uniqid(mt_rand(1,mt_getrandmax)),TRUE);
		
		//create salted password
		//$password=('sha512', $password.$random_salt);
		
		//insert the new user into the database
		if($insert_stmt=$mysqli->prepare("INSERT INTO members (username,email,password,salt)
			VALUES(?,?,?,?)")){
			$insert_stmt->bind_param('ssss',$email,$password,$random_salt);
			//Execute the prepared query
			if(!$insert_stmt->execute()){
				header('Location:../error.php?err=Registration failure: INSERT');
			}
		}
		 header('Location:./register_success.php'); 
		
	    }
	
	
	
}



?>