<?php
session_start();
if(isset($_SESSION['IJrPSPGxDmWIoQWnsmer3pISbG0A'])){
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




			$lines = file('upload/'.$file_path, FILE_IGNORE_NEW_LINES);
			$delimiter = "\r\n";
			$i = 1;
			$theArticle = 0;
			$sep = '&#009;';
			echo '<pre style="width:100%;float:left;">';
			echo 'ID'.$sep.'Loaded Date'.$sep.'Title'.$sep.'Article Body';
			echo $delimiter;
			$articleCount = 0;
			foreach ($lines as $line_num => $line) {
				/*
				echo $line;
				echo $delimiter;
*/

				if($theArticle > 0){
					//Count ... if == 7, then title
					// if == 10 article starts
					// Ends when "---- INDEX REFERENCES ---" starts
					$line = preg_replace('/[\t]/', ' ', $line);
					if($theArticle == 6){
						echo trim($line);
						$theArticle++;
					}else if($theArticle == 7){
						echo trim($line);
						echo $sep;						
						$theArticle++;					
					}else if ($theArticle >= 10){
						if(preg_match('/INDEX REFERENCES/',$line)){
							$theArticle = 0;
							echo $sep;
						}else if(preg_match('/The Dallas Morning News/',$line)){
							$theArticle++;
						}else{
							echo trim($line);
							echo ' ';
							$theArticle++;						
						}
					}else{
						$theArticle++;						
					}

				}else{
					if(preg_match('/END OF DOCUMENT/', $line)){
						echo $delimiter;
					}

					
					if(preg_match('/Loaded Date:/',$line)){
						$line = preg_replace('/Loaded Date:/', '', $line);
						echo $articleCount.$sep;
						$articleCount++;
						echo trim($line).$sep;
					}

					if(preg_match('/Dallas Morning News, The/',$line)){
						$theArticle = 1;
					}
/*
					if(preg_match('/COMPANY: /', $line)){
						$line = preg_replace('/COMPANY: /', '', $line);
						echo $line.$sep;
					}
					if(preg_match('/NEWS SUBJECT: /', $line)){
						$line = preg_replace('/NEWS SUBJECT: /', '', $line);
						echo $line.$sep;
					}
					if(preg_match('/INDUSTRY: /', $line)){
						$line = preg_replace('/INDUSTRY: /', '', $line);
						echo $line.$sep;
					}
					if(preg_match('/REGION: /', $line)){
						$line = preg_replace('/REGION: /', '', $line);
						echo $line.$sep;
					}
					if(preg_match('/OTHER INDEXING: /', $line)){
						$line = preg_replace('/OTHER INDEXING: /', '', $line);
						echo $line.$sep;
					}
					if(preg_match('/Word Count: /', $line)){
						$line = preg_replace('/Word Count: /', '', $line);
						echo $line;
					}
*/
					//Company, News Subject, Industry, Region, Other Indexing, Word Count

				}

			}
		}



		/*
echo $parsedCSV;

*/


		/* 	  echo "<a class='download' href=' " . "upload/" . $file_path."'>Download CSV</a>";     */

	} else {
		echo "Invalid file";
	}
echo '</pre>';
}else{
	header("Location: index.php");
	exit;
} ?>