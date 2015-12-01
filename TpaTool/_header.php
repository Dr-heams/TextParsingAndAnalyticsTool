<html>
<head>
<title>Text Parsing and Analytics Tool - Home</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
$('form input').change(function() {
    var filename = $(this).val();
    var lastIndex = filename.lastIndexOf("\\");
    if (lastIndex >= 0) {
        filename = filename.substring(lastIndex + 1);
    }
    $('form p').text(filename);
});
});

</script>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400' rel='stylesheet' type='text/css'>
<link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<a href="logout.php" class="logout"><img src="img/exit.svg" width="25px" style="margin-right:3px;"></a>
<?php
if (stripos($_SERVER['REQUEST_URI'], 'main.php')){
     echo '<p id="navigation">
     <strong>Import Articles</strong>
     <br><a href="upload.php" class="home">Austin-American Statesman</a>
     <br><a href="upload_dmn.php" class="home" >Dallas Morning News</a>
     <br><a href="upload_to.php" class="home" >Texas Observer</a>
     <br><br><strong>Querys</strong>
     <br><a href="keywordquery1.php" class="home" >KeywordQuery v1</a>
     <br><a href="regexquery1.php" class="home" >RegExQuery v1</a>';
}else{
     echo '<a href="main.php" class="home"><img src="img/home.svg" width="20px" style="margin-top:5px;margin-left:5px;"></a>';
}
?>
