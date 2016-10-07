<?php require_once('Connections/connection.php'); ?>
<?php
mysql_select_db($database_connection, $connection);
$query_login = "SELECT * FROM userregistration";
$login = mysql_query($query_login, $connection) or die(mysql_error());
$row_login = mysql_fetch_assoc($login);
$totalRows_login = mysql_num_rows($login);
?><?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "userid";
  $MM_redirectLoginSuccess = "account.php";
  $MM_redirectLoginFailed = "register.php";
  $MM_redirecttoReferrer = true;
  mysql_select_db($database_connection, $connection);
  	
  $LoginRS__query=sprintf("SELECT username, password, userid FROM userregistration WHERE username='%s' AND password='%s'",
  get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password)); 
   
  $LoginRS = mysql_query($LoginRS__query, $connection) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'userid');
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && true) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<link href="css/layout2.css" rel="stylesheet" type="text/css"/>
<link href="css/menu2.css" rel="stylesheet" type="text/css"/>



<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>

</head>

<body>
<div id="holder">
<div id="header">
  <h1>Globalstylings </h1>
</div>

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
  <p>&nbsp;</p>
  <div id="pageheading">
	  <h1>Login</h1>
	</div>
	<div id="contentleft">
	  <h2>come in.. </h2>
	  <br />
	  <h5></h5>
	</div>
	<div id="contentright">
	  <form ACTION="<?php echo $loginFormAction; ?>" id="login" name="login" method="POST">
	    <table width="400" align="center">
          <tr>
            <td><h5>
              <label>Username<br />
              <br />
                <input name="username" type="text" class="styletxtfield" id="username" />
                </label>
            </h5></td>
          </tr>
          <tr>
            <td></td>
          </tr>
          <tr>
            <td><h5>
              <label>Password<br />
              <br />
                <input name="password" type="text" class="styletxtfield" id="password" />
                </label>
            </h5></td>
          </tr>
          <tr>
            <td></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><input name="Submit" type="submit" class="styletxtfield" value="Login" /></td>
          </tr>
        </table>
      </form>
    </div>
 </div>
<div id="footer"> 
</div>

</div>
</body>
</html>
<?php
mysql_free_result($login);
?>