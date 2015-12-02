<?php
session_start();
if(isset($_SESSION['IJrPSPGxDmWIoQWnsmer3pISbG0A'])){
	header("Location: main.php");
	exit;
}else{

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
    <title>Text Parsing and Analytics Tool - Login</title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400' rel='stylesheet' type='text/css'>
    <link href="css/login.css" rel="stylesheet" type="text/css">
</head>

<body>
    <form method="post" action="checklogin.php" id="form1">
        <p>Please Login</p><input name="myusername" type="text" id="myusername" placeholder="Username"> <input name="mypassword" type="password" id="mypassword" placeholder="Password"> <input type="submit" name="Submit" value="Login">
    </form>
</body>
</html>
