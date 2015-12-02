<?php
session_start();
if(isset($_SESSION['IJrPSPGxDmWIoQWnsmer3pISbG0A'])){ ?>
<?php include '_header.php';?>
<div class="content2">
<?php
include("settings.php");
	// Check connection
	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$result = mysqli_query($con,"SELECT * FROM tables_meta");
	$i = 0;
	if(!is_bool($result)){
		while($row = mysqli_fetch_array($result)) {
			echo "<p class='listOfTables'>";
			echo '<span class="tableName">'.$row['table_name'].'</span><br>';
			echo '<strong>Description:</strong> '.$row['table_description'].'<br>';
			echo '<strong>Created: </strong>'.$row['date_created'].'<br>';
			echo "<form action='downloadsql.php' method='post'><input type='hidden' name='table' value='" . $row['table_name'] . "'> <input type='submit' value='Download SQL'></form> <a class='button' href='upload/" . $row['original_data'] . "'>Download TXT</a> <form action='deletesql.php' method='post'><input type='hidden' name='table' value='" . $row['table_name'] . "'><input type='hidden' name='file' value='" . $row['original_data'] . "'> <input class='delete' type='submit' value='Delete'></form>";
			echo "<br><br><br></p>";
			$i++;
		}
	}
	echo "</table>";
	mysqli_close($con);
?>
</div>
<?php include '_footer.php';?>
<?php }else{
	header("Location: index.php");
	exit;
} ?>