<?php
setcookie("Secret", "Your super secret session ID=5d440ff3c129c01993dc2b", time() + 3600);
?>
<!DOCTYPE HTML>
<html>
<head>
<link rel="shortcut icon" href="mat.ico">
<title>XSS Demo</title>
</head>
<body>
<h1>Very Flashy and Complicated Website 2</h1>
<p>Welcome to my site. This site has extreme security. My site can't be hacked.</p>
<p>How awesome am I??</p>

<form action="index.php" id="coolForm" method="post">
Leave me a comment: <input type="text" name="cool">
<input type="submit" value="submit">
</form>
<br>
<?php
if (isset($_POST['cool']) && !isset($_POST['button'])) {
	echo "<h1>Thanks for the compliment!</h1><br/>";
	echo "You said: "; 
	echo $_POST["cool"]; 
	file_put_contents("list.txt", trim($_POST["cool"]).PHP_EOL, FILE_APPEND);
} 
?>
<?php
    if (isset($_POST['button']))
    {
         exec('cat /dev/null > list.txt');
		 echo "Reset Complete!";
    }
?>
<br><br>

</body>

<?php 
if (!isset($_POST['button'])) {
	echo "<b>List of things people have said:</b><br/>\n";
	$lines = file("list.txt");
	foreach ($lines as $line_num => $line) {
	  echo "#<b>{$line_num}</b> : " . $line . "<br />\n";
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
