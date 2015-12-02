<?php
session_start();
if(isset($_SESSION['IJrPSPGxDmWIoQWnsmer3pISbG0A'])){
	include("settings.php");
	$whichTable = $_POST['table'];
	$filename = "backup-".$whichTable."_" . date("d-m-Y") . ".sql.gz";
	$mime = "application/x-gzip";

	header( "Content-Type: " . $mime );
	header( 'Content-Disposition: attachment; filename="' . $filename . '"' );

	$cmd = "mysqldump -u $username --password=$password $dbname $whichTable | gzip --best";

	passthru( $cmd );

	exit(0);
}else{
	header("Location: index.php");
	exit;

}
?>