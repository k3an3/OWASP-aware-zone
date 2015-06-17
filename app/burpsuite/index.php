<!DOCTYPE HTML>
<html>
<head>
<link rel="shortcut icon" href="/mat.ico">
<title>Burpsuite Demo</title>
</head>

<body>
<h1>Very Flashy and Complicated Website</h1>
<p>Welcome to my site. This site has extreme security. My site can't be hacked.</p>
<p>How awesome am I??</p>

<script type="text/javascript">
function validate()
{
   var frm = document.forms["coolForm"];
   if( frm.cool.value == "" ) {
     alert( "You need to enter something first! Something that says I'm awesome!" );
     frm.cool.focus() ;
     return false;
   }
   if (frm.cool.value.toUpperCase().indexOf("AWESOME") == -1) {
	alert("You didn't mention that I'm awesome! Try Again!");
	return false;
	}
    return true;
}

</script>

<form action="index.php" id="coolForm" onsubmit="return (validate());" method="post">
Tell me that I'm awesome: <input type="text" name="cool">
<input type="submit" value="submit">
</form>
<br>
<?php
if (isset($_POST['cool']) && !isset($_POST['button'])) {
	echo "<h1>Thanks for the compliment!</h1><br/>";
	echo "You said: ";
	echo htmlspecialchars($_POST["cool"]);
	file_put_contents("list.txt", trim($_POST["cool"]).PHP_EOL, FILE_APPEND);
}
?>
<?php
    if (isset($_POST['button'])|| $_GET['reset'] === 'true')
    {
         exec('cat /dev/null > list.txt');
		 echo "Reset Complete!";
    }
?>
<br><br>

</body>

<?php
if (!isset($_POST['button'])) {
	echo "<b>List of Awesome things people have said about me:</b><br/>\n";
	$lines = file("list.txt");
	foreach ($lines as $line_num => $line) {
	  echo "#<b>{$line_num}</b> : " . htmlspecialchars($line) . "<br />\n";
	}

	echo "<br/>";
}
?>

<form method="post">
    <p>
        <button name="button">Reset</button>
    </p>
</form>
<br>

<p style="font-size:10px"><a href="https://www.keaneokelley.com">Keane was here.</a></p>


</html>
