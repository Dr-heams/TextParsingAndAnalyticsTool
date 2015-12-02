<?php
session_start();
if(isset($_SESSION['IJrPSPGxDmWIoQWnsmer3pISbG0A'])){
	include("settings.php");
	$allowedExts = array("txt","TXT");
	$temp = explode(".", $_FILES["file"]["name"]);
	$extension = end($temp);

	if ((($_FILES["file"]["type"] == "text/plain")) && ($_FILES["file"]["size"] < 9000000) && in_array($extension, $allowedExts)) {
		if ($_FILES["file"]["error"] > 0) {
			echo "<p>" . $_FILES["file"]["error"] . "</p>";
		} else {

			$delimiter = "\r\n";
			$path_parts = pathinfo($_FILES["file"]["name"]);
			$file_path = $path_parts['filename'].'_'.date("Ymd").'_'.date("Hi").'.'.$path_parts['extension'];
			move_uploaded_file($_FILES["file"]["tmp_name"],"upload/" . $file_path);


			$temp = explode( '.', $file_path );
			$ext = array_pop( $temp );
			$sqlname = implode( '.', $temp );

			// Check connection
			if (mysqli_connect_errno()) {
				echo "Failed to connect to MySQL: " . mysqli_connect_error();
			}

			/* echo $sqlname; */
			$collectingArticleData = 0;

			// Create table
			$sql="CREATE TABLE $sqlname (id MEDIUMINT NOT NULL AUTO_INCREMENT, Source VARCHAR(240), Pub_Date DATE, Edition VARCHAR(240), Headline VARCHAR(400), Byline VARCHAR(400), Section VARCHAR(240), Length INT, Article TEXT, Language VARCHAR(120), Publication_Type VARCHAR(120), Subject MEDIUMTEXT, Person MEDIUMTEXT, State VARCHAR(120), Country VARCHAR(120), Load_Date DATE, Copyright VARCHAR(240), PRIMARY KEY (id))";

			// Execute query
			if (mysqli_query($con,$sql)) {
				/*   echo "Table ".$sqlname." created successfully"; */
			} else {
				echo "Error creating table: " . mysqli_error($con);
			}

			$lines = file('upload/'.$file_path, FILE_IGNORE_NEW_LINES);
			$delimiter = "<br/>";
			foreach ($lines as $line_num => $line) {
				if(preg_match('/DOCUMENTS/', $line)){
					preg_match('/\d{1,6}(?= of)/',$line,$thisArticleCount);
					preg_match('/\d{1,6}(?= DOCUMENTS)/',$line,$totalArticlesCount);
					$parsedCSV .= $delimiter.$delimiter.'Document '.$thisArticleCount[0] . " of " . $totalArticlesCount[0]. $delimiter;
					$start_article = $line_num;
				}else if(isset($start_article)){
						if($line_num == $start_article + 3){
							$theSource = $line;
							$parsedCSV .= 'Source: '.$line . $delimiter;
						}else if($line_num == $start_article + 5){
								$line = date("Y-m-d", strtotime($line));
								$thePubDate = $line;
								$parsedCSV .= 'Pub Date: '.$line.$delimiter;
							}else if($line_num == $start_article + 6){
								$theEdition = $line;
								$parsedCSV .= 'Edition: '.$line;
							}else if($line_num == $start_article + 7){
								if($line == ''){
									$parsedCSV .= $delimiter;
									$headline = $line_num + 1;
								}else{
									$parsedCSV .= ', ' .$line . $delimiter;
									$headline = $line_num + 2;
								}
							}else if(isset($headline)){
								if($line_num == $headline){
									$theHeadline = $line;
									$parsedCSV .= "Headline: ".$line . $delimiter;
								}
							}
						if(preg_match('/BYLINE/', $line)){
							$line = preg_replace('/BYLINE: /', '', $line);
							$theByline = $line;
							$parsedCSV .= 'Byline: ' . $line.$delimiter;
						}
						if(preg_match('/SECTION/', $line)){
							$line = preg_replace('/SECTION: /', '', $line);
							$theSection = $line;
							$parsedCSV .= 'Section: ' . $line.$delimiter;
						}
						if(preg_match('/LENGTH/', $line)){
							$line = preg_replace('/LENGTH: /', '', $line);
							$theLength = $line;
							$parsedCSV .= 'Length: ' . $line.$delimiter;
							$articleStart = $line_num + 1;

						}
						if($articleStart == $line_num){
							$articleEcho = 1;
						}
						if($articleEcho == 1){
							if($line_num == $articleStart+1){
								$theArticle = $line;
								$parsedCSV .= 'Article: '. $line;
							}else if(preg_match('/LANGUAGE/', $line)){
									$articleEcho = 0;
								}else {
								$theArticle .= $line;
								$parsedCSV .= $line;
							}
						}
						if(preg_match('/LANGUAGE: /', $line)){
							$line = preg_replace('/LANGUAGE: /', '', $line);
							$theLanguage = $line;
							$parsedCSV .= $delimiter. 'Language: ' . $line. $delimiter;
						}
						if(preg_match('/PUBLICATION-TYPE: /', $line)){
							$line = preg_replace('/PUBLICATION-TYPE: /', '', $line);
							$thePublicationType = $line;
							$parsedCSV .= 'Publication-Type: ' . $line.$delimiter;
						}
						if(preg_match('/SUBJECT: /', $line)){
							$line = preg_replace('/SUBJECT: /', '', $line);
							$theSubject = $line;
							$parsedCSV .= 'Subject: ' . $line.$delimiter;
						}
						if(preg_match('/PERSON: /', $line)){
							$line = preg_replace('/PERSON: /', '', $line);
							$thePerson = $line;
							$parsedCSV .= 'Person:' . $line.$delimiter;
						}
						if(preg_match('/STATE: /', $line)){
							$line = preg_replace('/STATE: /', '', $line);
							$theState = $line;
							$parsedCSV .= 'State: ' . $line. $delimiter;
						}
						if(preg_match('/COUNTRY: /', $line)){
							$line = preg_replace('/COUNTRY: /', '', $line);
							$theCountry = $line;
							$parsedCSV .= 'Country: ' . $line.$delimiter;
						}
						if(preg_match('/LOAD-DATE: /', $line)){
							$line = preg_replace('/LOAD-DATE: /', '', $line);
							$line = date("Y-m-d", strtotime($line));
							$theLoadDate = $line;
							$parsedCSV .= 'Load-Date: ' .$line.$delimiter;
							$copyrightNotice = $line_num + 3;
						}
						if(preg_match('/Copyright /', $line)){
							$theCopyright = $line;
							$parsedCSV .= "Copyright Notice: ". $line;
							$collectingArticleData = 1;
						}
						if($line_num == $copyrightNotice + 1){
							if($line == ''){

							}else{
								$parsedCSV .= ', '. $line;
							}

						}
					}
				if($collectingArticleData == 1){
					$theSource = mysqli_real_escape_string($con, $theSource );
					$thePubDate = mysqli_real_escape_string($con, $thePubDate);
					$theEdition = mysqli_real_escape_string($con, $theEdition);
					$theHeadline = mysqli_real_escape_string($con, $theHeadline);
					$theByline = mysqli_real_escape_string($con, $theByline);
					$theSection = mysqli_real_escape_string($con, $theSection);
					$theLength = mysqli_real_escape_string($con, $theLength);
					$theArticle = mysqli_real_escape_string($con, $theArticle);
					$theLanguage = mysqli_real_escape_string($con, $theLanguage);
					$thePublicationType = mysqli_real_escape_string($con, $thePublicationType);
					$theSubject = mysqli_real_escape_string($con, $theSubject);
					$thePerson = mysqli_real_escape_string($con, $thePerson);
					$theState = mysqli_real_escape_string($con, $theState);
					$theCountry = mysqli_real_escape_string($con, $theCountry);
					$theLoadDate = mysqli_real_escape_string($con, $theLoadDate);
					$theCopyright = mysqli_real_escape_string($con, $theCopyright);
					$sqlarticle="INSERT INTO $sqlname (Source, Pub_Date, Edition, Headline, Byline, Section, Length, Article, Language, Publication_Type, Subject, Person, State, Country, Load_Date, Copyright) VALUES('$theSource', '$thePubDate', '$theEdition', '$theHeadline', '$theByline', '$theSection', '$theLength', '$theArticle', '$theLanguage', '$thePublicationType', '$theSubject', '$thePerson', '$theState', '$theCountry', '$theLoadDate', '$theCopyright')";
					if (!mysqli_query($con,$sqlarticle)) {
						die('Article Error: ' . mysqli_error($con));
					}
					$collectingArticleData = 0;
				}
			}
			$description = $_POST['description'];
			$description = mysqli_real_escape_string($con, $description);
			$rightnow = date("Y-m-d");
			$sql="INSERT INTO tables_meta (table_name, table_description, original_data, date_created, referenced_table_name)
VALUES ('$sqlname', '$description', '$file_path', '$rightnow','$sqlname')";
			if (!mysqli_query($con,$sql)) {
				die('Error: ' . mysqli_error($con));
			}
		}
	} else {
		echo "Invalid file";
	}
	header("Location: main.php");
}else{
	header("Location: index.php");
	exit;
} ?>