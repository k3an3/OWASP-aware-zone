<html>
<head>
<link rel="shortcut icon" href="mat.ico">
</head>
<body>

<h1>Thanks for the compliment!</h1><br>
<?php 
if (isset($_POST['cool']) && !isset($_POST['button'])) {

	echo "You said: "; echo $_POST["cool"]; file_put_contents("list.txt", trim($_POST["cool"]).PHP_EOL, FILE_APPEND);
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
	echo "<b>List of Awesome things people have said about me:</b><br/>\n";
	$lines = file("list.txt");
	if(isset($_POST['imagebutton'])) {
		foreach ($lines as $line_num => $line) {
		echo "#<b>{$line_num}</b> : " . htmlspecialchars($line) . "<br />\n";
		}
	} else {
		foreach ($lines as $line_num => $line) {
		echo "#<b>{$line_num}</b> : " . ($line) . "<br />\n";
		}
?>
	<form method="post">
    <p><button name="imagebutton">Ignore html</button></p>
	</form>
<?php
	}	
}
?>

<a href="index.php"><button type="button">Try Again</button></a> 
<form method="post">
    <p>
        <button name="button">Reset</button>
    </p>
</form>
<br>

<html>
<p style="font-size:8px">Keane Was Here</p>
</html>