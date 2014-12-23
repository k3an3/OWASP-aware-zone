<?php 
$conn = mysqli_connect('localhost', 'username', 'password');
if(!$conn) {
  die('MySQL Error: ' . mysqli_error($conn));
}
mysqli_select_db($conn, 'sqldemo');
if(isset($_GET['session'])) {
  $session = $_GET['session'];
  $res = mysqli_query($conn, "SELECT * FROM Sessions WHERE sessionID = $session");
  if(!$res)
      die("Unable to log in. " . mysqli_error($conn));
  $data = mysqli_fetch_assoc($result);
  $username = $data['username'];
  echo "<script>alert('$username logged in');</script>";
  setcookie("session", $session, time() + 3600);
}
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
    $page = 1;
} else {
    $page = $_GET['page'];
}
if($_GET['username']) {
    $user = $_GET['username'];
    echo "Logged in as " . $user .".<br/><br/>";
?>
    <form action="index.php" id="coolForm" method="post">
    Leave me a comment:<br/><input type="text" placeholder="Title" name="title"><br>
    <textarea type="text" placeholder="Message" name="body" rows="6"></textarea><br/>
    <input type="submit" value="submit">
    </form>
    <br>
    
<?php
} else { 
     echo '<br/>You are not logged in. <a href="login.php">Log in</a> or <a href="newaccount.php">create an account</a> in order to post.<br/>';
}
if ($_POST['title'] !== null && $_POST['body'] !== null && !isset($_POST['button'])) {
	$title = $_POST['title'];
	$body = $_POST['body'];
	echo "<h1>Thanks for posting!</h1><br/>";
	$result = mysqli_query($conn, "INSERT INTO Comments (Title, Body, User) values ('$title', '$body', '$user')");
	if (!$result) 
	    die("Failed to post. MySQL Error: " . mysqli_error($conn));
} 
if (isset($_POST['button']))
{
	$reset = mysqli_query($conn, "Truncate table Comments");
	if (!$reset) {
	     die('Reset error: ' . mysqli_error($conn));
	 }
	echo "Reset Complete!";
}
?>
<br><br>

<div class="post">

<?php 
if (!isset($_POST['button'])) {
	echo "<b>Page $page:</b><br/>\n";
	$result = mysqli_query($conn, "SELECT * FROM Comments WHERE page = '$page'");
	if(!$result) {
	    die('MySQL Error 2: ' . mysqli_error($conn));
	}
	$data = mysqli_fetch_array($result, MYSQL_ASSOC);
	echo "<h2>" . trim($data['Title']) . "</h2><br/><p>" . trim($data['Body']) . "<br/><br/>";
	echo "<i>Posted by {$data['User']}</i><br/>";	
	echo "<br/>";
}
echo "<a href='index.php?page=" . ($page - 1) . "'><button>Previous page</button></a>";
echo "<a href='index.php?page=" . ($page + 1) . "'><button>Next page</button></a>";

?>
</div>
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
Insert hint here.
</div>
<?php
}
?>

<p style="font-size:10px"><a href="https://www.keaneokelley.com">Keane was here.</a></p>

</body>
</html>
