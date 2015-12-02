<?php
session_start();
if(isset($_SESSION['IJrPSPGxDmWIoQWnsmer3pISbG0A'])){?>
<?php include '_header.php';?>
<form action="regexquery1_perform.php" class="keyword regex" method="post" enctype="multipart/form-data">
  <p>Paste your <strong>RegEx</strong> here:</p>
  <textarea name="regex" id="regex" placeholder="RegEx">([A-Z][a-zA-Z0-9-]*)([\s][A-Z][a-zA-Z0-9-]*)+</textarea>
  <button type="submit">Perform RegEx Query v1</button>
  <p>Action explanation:</p>
  <pre>
	<code>
foreach article check the regular expression

NOTE:
- Don't use opening and closing "/"

	</code>
</pre>
  </form>
<?php include '_footer.php';?>
<?php }else{
	header("Location: index.php");
	exit;
}?>