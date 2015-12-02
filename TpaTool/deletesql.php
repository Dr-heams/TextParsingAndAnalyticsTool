<?php
session_start();
if(isset($_SESSION['IJrPSPGxDmWIoQWnsmer3pISbG0A'])){
	include("settings.php");
	// Check connection
	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$tablename = $_POST['table'];
	mysqli_query($con,"DELETE FROM tables_meta WHERE table_name='$tablename'");
	mysqli_query($con,"DROP TABLE $tablename");


	mysqli_close($con);


	unlink('upload/'.$_POST['file']);
	header("Location: main.php");
	exit;


}else{
	header("Location: index.php");
	exit;

}
?>
