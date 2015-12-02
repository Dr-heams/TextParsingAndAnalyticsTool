<?php
session_start();
if(isset($_SESSION['IJrPSPGxDmWIoQWnsmer3pISbG0A'])){?>
<?php include '_header.php';?>
<form action="upload_file_westlaw.php" class="upload" method="post" enctype="multipart/form-data">
  <input type="file" name="file" id="file">
  <p>Drag your <strong>Westlaw</strong> files here or click in this area.</p>
  <textarea name="description"	id="description" placeholder="Description"></textarea>
  <button type="submit">Upload</button>
</form>
<?php include '_footer.php';?>
<?php }else{
	header("Location: index.php");
	exit;
}?>