<?php
// login processing
include_once 'db_connect.php';
include_once 'functions.php';
sec_session_start(); //the custom secure way of starting a php session
if(isset($_POST['email'],$_POST['p'])){
	$email=$_POST['email'];
	$password=$_POST['p'];  //the hashed password
	
	if(login($email,$password,$mysqli)==true){
		//login success
		
		header('Location:../protected_page.php');
	}else{
		//login failed
		header('Location:../index.php?error=1');
	}
}else{
	//the correct POST variables werent sent to this page
echo 'Invalid request';	
}


?>