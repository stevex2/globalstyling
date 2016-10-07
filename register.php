<?php require_once('Connections/connection.php'); ?>
<?php
// *** Redirect if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {
  $MM_dupKeyRedirect="register.php";
  $loginUsername = $_POST['username'];
  $LoginRS__query = "SELECT username FROM userregistration WHERE username='" . $loginUsername . "'";
  mysql_select_db($database_connection, $connection);
  $LoginRS=mysql_query($LoginRS__query, $connection) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    //append the username to the redirect page
    if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
    header ("Location: $MM_dupKeyRedirect");
    exit;
  }
}

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "registerform")) {
  $insertSQL = sprintf("INSERT INTO userregistration (fname, lname, email, username, password) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['fname'], "text"),
                       GetSQLValueString($_POST['lname'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"));

  mysql_select_db($database_connection, $connection);
  $Result1 = mysql_query($insertSQL, $connection) or die(mysql_error());

  $insertGoTo = "login.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_connection, $connection);
$query_register = "SELECT * FROM userregistration";
$register = mysql_query($query_register, $connection) or die(mysql_error());
$row_register = mysql_fetch_assoc($register);
$totalRows_register = mysql_num_rows($register);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<link href= "css/layout2.css" rel="stylesheet" type="text/css"/>
<link href="css/menu2.css" rel="stylesheet" type="text/css"/>



<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>

</head>

<body>
<div id="holder">
<div id="header">

  <h1>Global Stylings</h1>
  <p></p>
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
  <div id="pageheading">
	  <h1>Sign up </h1>
	</div>
	<div id="contentleft">
	  <h2>Welcome to globalstylings </h2>
	  <br />
	  <h5>Thank you for your interest and congratulations for choosing one the best salons in the world
	  <p>Please register to book an appointment  </p></h5>
	</div>
	<div id="contentright">
	  <form action="<?php echo $editFormAction; ?>" id="registerform" name="registerform" method="POST">
	    <table width="400" align="center">
          <tr>
            <td><table>
              <tr>
                <td><h5>
                  <label>First Name : <br />
                  <br />
                    <input name="fname" type="text" class="styletxtfield" id="fname" />
                    </label>
                </h5></td>
                <td><h5>
                  <label> Lastname : <br />
                  <br />  
                    <input name="lname" type="text" class="styletxtfield" id="lname" />
                    </label>
                </h5></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            
          </tr>
          <tr>
            <td><h5>
              <label>Email :<br /> 
              <br />  
                <input name="email" type="text" class="styletxtfield" id="email"/>
                </label>
            </h5></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><h5>
              <label>Username :<br />
              <br />
                <input name="username" type="text" class="styletxtfield" id="username" value="" />
                </label>
            </h5></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table>
              <tr>
                <td><h5>
                  <label> Password : <br />
                  <br />  
                    <input name="password" type="text" class="styletxtfield" id="password" />
                    </label>
                </h5></td>
                <td><h5>
                  <label> Confirm password :<br />
                  <br />
                    <input name="confirmpassword" type="text" class="styletxtfield" id="confirmpassword" />
                    </label>
                </h5></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><h5>
              <label>
                <input name="Submit" type="submit" class="styletxtfield" id="register" value="Register" />
                </label>
            </h5></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
      
          <input type="hidden" name="MM_insert" value="registerform">
      </form>
    </div>
 </div>
<div id="footer"></div>

</div>
</body>
</html>
<?php
mysql_free_result($register);
?>