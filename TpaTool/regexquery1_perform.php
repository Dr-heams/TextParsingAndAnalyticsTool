<?php
session_start();
if(isset($_SESSION['IJrPSPGxDmWIoQWnsmer3pISbG0A'])){
	include("settings.php");
	echo "<pre><code>NOTES:\n- all values are tab separated\n\nREGEX: ";
	$regex = "/".$_POST['regex']."/";
	echo $regex;
	echo "\n\n---\n\n";
	echo "KEYWORD FOUND\tARTICLE ID\n";
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$sql = "SELECT id, Article FROM Master_List WHERE 1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$string = $row['Article'];
			preg_match_all($regex, substr($string,3), $matches, PREG_OFFSET_CAPTURE);
			foreach($matches[0] as $value){
				echo $row['id'];
				echo "\t";
				echo $value[0];
				echo "\n";
			}
		}
	} else {
		echo "Fail";
	}
	$conn->close();
	echo '</code></pre>';
}else{
	header("Location: index.php");
	exit;
} ?>