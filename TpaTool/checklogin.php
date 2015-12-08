<?php
ob_start();
include("settings.php");
$tbl_name="members"; // Table name
// Connect to server and select databse.
mysql_connect("$servername", "$username", "$password")or die("cannot connect");
mysql_select_db("$dbname")or die("cannot select DB");

// Define $myusername and $mypassword
$myusername=$_POST['myusername'];
$mypassword=$_POST['mypassword'];
$IJrPSPGxDmWIoQWnsmer3pISbG0A = 'YES';

// To protect MySQL injection (more detail about MySQL injection)
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);
$sql="SELECT * FROM $tbl_name WHERE username='$myusername' and password='$mypassword'";
$result=mysql_query($sql);

// Mysql_num_row is counting table row
$count=mysql_num_rows($result);

// If result matched $myusername and $mypassword, table row must be 1 row
if($count==1){
	// Register $myusername, $mypassword and redirect to file "login_success.php"
session_start();	
	$_SESSION["IJrPSPGxDmWIoQWnsmer3pISbG0A"] = "IJrPSPGxDmWIoQWnsmer3pISbG0A";
	header("location:main.php");
}
else {
	echo "Wrong Username or Password";
}
ob_end_flush();
?>