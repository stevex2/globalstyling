<?php @session_start(); ?>
<?php require_once('Connections/connection.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "2";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
mysql_select_db($database_connection, $connection);
$query_user = "SELECT * FROM userregistration";
$user = mysql_query($query_user, $connection) or die(mysql_error());
$row_user = mysql_fetch_assoc($user);
$totalRows_user = mysql_num_rows($user);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<link href="css/layout2.css" rel="stylesheet" type="text/css"/>
<link href="css/menu2.css" rel="stylesheet" type="text/css"/>



<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>

</head>

<body>
q
<div id="holder">
<div id="header">head</div>

<div id="navbar"> 
	<nav>
		<ul>
			<li> <a href="#">Login</a> </li>
			<li> <a href="#">Register</a></li>
			<li> <a href="#">Forgot Password</a> </li>
		</ul>
 	</nav>  
</div>

<div id="content">
  <div id="pageheading">
	  <h1>Admin CP </h1>
	</div>
	<div id="contentleft">
	  <h2>admin links</h2>
	  <p>update user info </p>
	  <p>add products</p>
	  <p>manage users</p>
	  <p>send maillist</p>
	  <p>&nbsp;   </p>
	  <p>links</p>
	  <h5>&nbsp;</h5>
	</div>
	<div id="contentright"></div>
 </div>
<div id="footer">f</div>

</div>
</body>
</html>
<?php
mysql_free_result($user);
?>
