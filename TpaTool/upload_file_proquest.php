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
			echo 'ID'.$sep.'Title'.$sep.'Author'.$sep.'Article Body'.$sep.'Subject'.$sep.'Publication Title'.$sep.'Volume'.$sep.'Issue'.$sep.'Pages'.$sep.'Number of Pages'.$sep.'Publication Year'.$sep.'Publication Date'.$sep.'Year'.$sep.'ISSN'.$sep.'Document URL';
			echo $delimiter;
			$articleCount = 1;
			foreach ($lines as $line_num => $line) {
				if(preg_match('/Document '.$articleCount.' of /',$line)){
					echo $articleCount.$sep;
					$theArticle=1;
				}else if($theArticle == 1){
						$theArticle=2;
					}else if($theArticle == 2){
						echo trim($line).$sep;
						$theArticle=3;
					}else if($theArticle == 4){
						if(preg_match('/Subject: /', $line) || preg_match('/Publication title: /', $line)){
							$theArticle = 0;
							echo $sep;
						}else{
							$line = preg_replace('/[\t]/', ' ', $line);
							echo trim($line);
							echo ' ';
						}
					}else if(preg_match('/Full text: /', $line)){
						$line = preg_replace('/Full text: /', '', $line);
						$line = preg_replace('/[\t]/', ' ', $line);
						echo trim($line);
						echo ' ';
						$theArticle = 4;
					}
				if(preg_match('/Publication Date: /', $line)){
					$line = preg_replace('/Publication Date:/', '', $line);
					echo trim($line).$sep;
				}else if(preg_match('/Author: /', $line)){
						$line = preg_replace('/Author:/', '', $line);
						echo trim($line).$sep;
					}else if(preg_match('/Document URL: /', $line)){
						$line = preg_replace('/Document URL:/', '', $line);
						echo trim($line).$sep;
						echo $delimiter;
						$articleCount++;
					}else if(preg_match('/Volume: /', $line)){
						$line = preg_replace('/Volume:/', '', $line);
						echo trim($line).$sep;
					}else if(preg_match('/Issue: /', $line)){
						$line = preg_replace('/Issue:/', '', $line);
						echo trim($line).$sep;
					}else if(preg_match('/Pages: /', $line)){
						$line = preg_replace('/Pages:/', '', $line);
						echo trim($line).$sep;
					}else if(preg_match('/Number of pages: /', $line)){
						$line = preg_replace('/Number of pages:/', '', $line);
						echo trim($line).$sep;
					}else if(preg_match('/Publication year: /', $line)){
						$line = preg_replace('/Publication year:/', '', $line);
						echo trim($line).$sep;
					}else if(preg_match('/Publication date: /', $line)){
						$line = preg_replace('/Publication date:/', '', $line);
						echo trim($line).$sep;
					}else if(preg_match('/Year: /', $line)){
						$line = preg_replace('/Year:/', '', $line);
						echo trim($line).$sep;
					}else if(preg_match('/ISSN: /', $line)){
						$line = preg_replace('/ISSN:/', '', $line);
						echo trim($line).$sep;
					}
				if(preg_match('/Publication title: /', $line)){
					$line = preg_replace('/Publication title:/', '', $line);
					echo trim($line).$sep;
				}
			}
		}
	} else {
		echo "Invalid file";
	}
	echo '</pre>';
}else{
	header("Location: index.php");
	exit;
} ?>