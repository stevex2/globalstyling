<?php require_once('Connections/connection.php'); ?>
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

<style type="text/css">
<!--
.style1 {font-family: Arial, Helvetica, sans-serif}
-->
</style>
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
	  <h1>Update Account </h1>
	</div>
	<div id="contentleft">
	  <h2>Account Links</h2>
	  <p>&nbsp; </p>
	  <br />
	  <h5>links</h5>
	</div>
	<div id="contentright">
	  <form id="updateform" name="updateform" method="post" action="">
	    <table width="600" align="center">
          <tr>
            <td> <h1>Account:<?php echo $row_user['fname']; ?><?php echo $row_user['lname']; ?></h1></td>
          </tr>
        </table>
        <table width="400" align="center">
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr class="styletxtfield">
            <td><label>Email:<br />
              <br />
</label> 
            <input name="textfield" type="text" class="styletxtfield" value="<?php echo $row_user['email']; ?>" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr class="styletxtfield">
            <td><label>Password</label>
                <p>
                  <input name="textfield2" type="text" class="styletxtfield" value="<?php echo $row_user['password']; ?>" />
                </p></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
        <p>&nbsp;</p>
	  </form>
    </div>
 </div>
<div id="footer"></div>

</div>
</body>
</html>
<?php
mysql_free_result($user);
?>
