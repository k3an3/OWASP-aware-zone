<?php
setcookie("SuperSecretCookie", $_SERVER['REMOTE_ADDR'], time() + 3600);
?>
<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../css/demo.css" />
<link rel="shortcut icon" href="/mat.ico">
<title>XSS Demo</title>
</head>
<body>
<h1>Very Flashy and Complicated Website 2</h1>
<p>Welcome to my site. This site has extreme security. My site can't be hacked.</p>

<form action="index.php" id="coolForm" method="post">
Leave me a comment: <input type="text" name="cool">
<input type="submit" value="submit">
</form>
<br>
<?php
/* Take whatever the user posts, and save it to file. */
if (isset($_POST['cool']) && !isset($_POST['button'])) {
	echo "<h1>Thanks for posting!</h1><br/>";
	echo "You said: "; 
	echo $_POST["cool"]; 
	file_put_contents("list.txt", trim($_POST["cool"]).PHP_EOL, FILE_APPEND);
} 
?>
<?php
    if (isset($_POST['button']) || $_GET['reset'] === 'true')
    {
         exec('cat /dev/null > list.txt');
		 echo "Reset Complete!";
    }
?>
<br><br>

</body>

<?php 
/* Display the list of things people said, exactly as they were stored. */
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

<a href="index.php?hint=true">Hint</a>

<?php 
if(isset($_GET['hint'])) {
?>
<div class="hint">
Since the user input is not stripped or validated, any HTML you type into the text field will be rendered on the page as if it was part of the source. Try adding some text inside header tags, such as
"<?php echo htmlspecialchars('<h1>Hello World!</h1>'); ?>" to show how you can manipulate the text. You could also try to add images or even embed YouTube videos. While none of this is particularily malicious, there are plenty of harmful things that can be done.
You could try to insert an HTML or Javascript redirect, which would send users to a different page without them even noticing. Even worse, you could use Javascript to steal cookie values
and send them to a different website for harvesting. A <a href="cookiecollector.php">Cookie Collector</a> page has been provided for testing this.
</div>
<?php
}
?>

<p style="font-size:10px"><a href="https://www.keaneokelley.com">Keane was here.</a></p>


</html>
