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
<a href="logout.php" class="logout"><img src="img/exit.svg" width="25px" style="margin-right:3px;margin-top:5px;"></a>
<p id="navigation">
	 <strong>Home</strong>
	 <br><a href="main.php" class="home">Main</a>
     <br><br><strong>Import Articles</strong>
     <br><a href="upload_lexus.php" class="home">LexusNexus (to SQL)</a>
     <br><a href="upload_westlaw.php" class="home" >Westlaw (to TSV)</a>
     <br><a href="upload_proquest.php" class="home" >ProQuest (to TSV)</a>
     <br><br><strong>Sample Formats</strong>
     <br><a href="sampleFiles/LexusNexus_Sample_Format.txt" class="home" >LexusNexus Sample</a>
     <br><a href="sampleFiles/ProQuest_Sample_Format.txt" class="home" >ProQuest Sample</a>
     <br><a href="sampleFiles/Westlaw_Sample_Format.txt" class="home" >Westlaw Sample</a>     
     <br><br><br><br><strong>Querys</strong>
     <br><a href="keywordquery1.php" class="home" >KeywordQuery v1</a>
     <br><a href="regexquery1.php" class="home" >RegExQuery v1</a>
	 
</p>
