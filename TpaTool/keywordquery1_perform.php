<?php
session_start();
if(isset($_SESSION['IJrPSPGxDmWIoQWnsmer3pISbG0A'])){
	include("settings.php");
	echo "<pre><code>NOTES:\n- PHP Search isn't very smart so there may be no article text\n- all values are tab separated\n\nKEYWORDS: ";
	echo $_POST['keywords'];
	$keyword = explode(',', $_POST['keywords']);
	echo "\n\n---\n\n";


	// Check connection
	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	// Search table
	$sql="SELECT Pub_Date, count(*) FROM Master_List WHERE match(Article) against('restrictions') GROUP By Pub_Date";

	// Execute query
	if (mysqli_query($con,$sql)) {
	} else {
		echo "Error creating table: " . mysqli_error($con);
	}
	
	echo "KEYWORD\t# FOUND IN MASTER LIST\t# FOUND IN ARTICLES\tPUB DATE\tARTICLE ID\tFIRST OCCURANCE AND PRECEEDING 60 CHARACTERS\n";
	foreach($keyword as $key => $value){
		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		$link = mysql_connect($servername, $username, $password);
		mysql_select_db($dbname, $link);
		$myValue = '"'.trim($value).'"';
		$result = mysql_query("SELECT Pub_Date, count(*) FROM Master_List WHERE match(Article) against('$myValue' IN BOOLEAN MODE) GROUP By Pub_Date", $link);
		$num_rows = mysql_num_rows($result);
		$sql = "SELECT Pub_Date, count(*), id, Article FROM Master_List WHERE match(Article) against('$myValue' IN BOOLEAN MODE) GROUP By Pub_Date";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
			// output data of each row
			while($row = $result->fetch_assoc()) {
				echo trim($value);
				echo "\t";
				echo $num_rows;
				echo "\t";
				echo $row["count(*)"];
				echo "\t";
				echo $row["Pub_Date"];
				echo "\t";
				echo $row["id"];
				echo "\t";
				/*
			$pos = strpos($row["Article"],trim($value),0);
			echo $pos;
*/
				$string = stristr($row["Article"], trim($value), true).trim($value);
				echo substr($string, strlen($string)-60, 60);
				echo "\n";

			}
		} else {
			echo trim($value);
			echo "\t";
			echo "0";
			echo "\t";
			echo "0";
			echo "\t";
			echo "";
			echo "\t";
			echo "";
			echo "\t";
			echo "";
			echo "\n";
		}
		$conn->close();
	}
	echo "</code></pre>";
}else{
	header("Location: index.php");
	exit;
} ?>