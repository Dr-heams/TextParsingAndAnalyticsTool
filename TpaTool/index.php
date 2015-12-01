<?php
session_start();
if(isset($_SESSION['IJrPSPGxDmWIoQWnsmer3pISbG0A'])){
header("Location: main.php");	
exit;
}else{

}
?>
<html>
<head>
<title>Text Parsing and Analytics Tool - Login</title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400' rel='stylesheet' type='text/css'>
<link href="css/login.css" rel="stylesheet" type="text/css">
</head>

<body>


<form name="form1" method="post" action="checklogin.php">
<p>Please Login</p>
<input name="myusername" type="text" id="myusername" placeholder="Username">
<input name="mypassword" type="password" id="mypassword" placeholder="Password">
<input type="submit" name="Submit" value="Login">
</form>
</body>
</html>
