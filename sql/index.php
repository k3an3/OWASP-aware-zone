<?php
setcookie("SuperSecretCookie", $_SERVER['REMOTE_ADDR'], time() + 3600);
?>
<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../css/demo.css" />
<link rel="shortcut icon" href="mat.ico">
<title>SQL Injection Demo</title>
</head>

<?php 
$conn = mysqli_connect('localhost', 'username', 'password');
if(!$conn) {
  die('MySQL Error: ' . mysqli_error($conn));
}
mysqli_select_db($conn, 'sqldemo');
?>
<body>
<h1>Very Flashy and Complicated Website 3</h1>
<p>Welcome to my site. This site has extreme security. I have learned how to do everything with MySQL. My site can't be hacked.</p>


<?php 
if(!isset($_GET['page'])) {
    $page = 0;
} else {
    $page = $_GET['page'];
}
if($loggedin === TRUE) {?>
    <form action="index.php" id="coolForm" method="post">
    Leave me a comment: <input type="text" name="cool">
    <input type="submit" value="submit">
    </form>
    <br>
<?php
} else { 
     echo "<br/>You are not logged in. Log in or create an account in order to post.";
}
if (isset($_POST['cool']) && !isset($_POST['button'])) {
	echo "<h1>Thanks for posting!</h1><br/>";
	echo "You said: "; 
	echo $_POST["cool"]; 
	file_put_contents("list.txt", trim($_POST["cool"]).PHP_EOL, FILE_APPEND);
} 
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
	$result = mysqli_query($conn, "SELECT $page FROM Comments");
	if(!$result) {
	    die('MySQL Error 2: ' . mysqli_error($conn));
	}
	$data = mysql_fetch_array($result, MYSQL_ASSOC);
	echo "<h2>{$data['Title']}</h2><br/><p>{$data['Body']}";
	
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
