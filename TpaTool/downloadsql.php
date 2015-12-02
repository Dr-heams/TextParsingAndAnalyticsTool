<?php
session_start();
if(isset($_SESSION['IJrPSPGxDmWIoQWnsmer3pISbG0A'])){
	$whichTable = $_POST['table'];

	$DBUSER="ak5a_tpatool";
	$DBPASSWD="password1234";
	$DATABASE="ak5a_tpatool";

	$filename = "backup-".$whichTable."_" . date("d-m-Y") . ".sql.gz";
	$mime = "application/x-gzip";

	header( "Content-Type: " . $mime );
	header( 'Content-Disposition: attachment; filename="' . $filename . '"' );

	$cmd = "mysqldump -u $DBUSER --password=$DBPASSWD $DATABASE $whichTable | gzip --best";

	passthru( $cmd );

	exit(0);
}else{
	header("Location: index.php");
	exit;

}
?>