<?php
session_start();
if(isset($_SESSION['IJrPSPGxDmWIoQWnsmer3pISbG0A'])){?>

<?php include '_header.php';?>

<form action="keywordquery1_perform.php" class="keyword" method="post" enctype="multipart/form-data">
  <p>Paste your <strong>Keywords</strong> here:</p>

  <textarea name="keywords"	id="keywords" placeholder="Keyword, Keyword, Keyword, etc..."></textarea>
  <button type="submit">Perform Keyword Query v1</button>
  <p>Action explanation:</p>
  <pre>
	<code>
foreach $keyword
	SELECT SELECT Pub_Date,
		count(*)
	FROM
		Master_List
	WHERE
		match(Article) against('$keyword')
	GROUP By // THIS MAY CHANGE
		Pub_Date;

Then print tab separated value list of

KEYWORD		TOTAL COUNT		ARTICLE ID		+/- 30 CHARACTERS AROUND KEYWORD	

Can then be copied and pasted by user into Numbers, Pages or Text program
	</code>
</pre>
  </form>


<?php include '_footer.php';?>
<?php }else{
header("Location: index.php");	
exit;
}
?>