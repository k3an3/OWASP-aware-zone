<?php 
$conn = mysqli_connect('localhost', 'username', 'password');
if(!$conn) {
  die('MySQL Error: ' . mysqli_error($conn));
}
mysqli_select_db($conn, 'sqldemo');
if(isset($_COOKIE['session'])) {
  $res = mysqli_query($conn, "SELECT * FROM Sessions WHERE sessionID = {$_COOKIE['session']}");
  if(mysqli_num_rows($res) > 0) {
      $data = mysqli_fetch_assoc($res);
      $username = $data['username'];
      $loggedin = true;
  } else {
      $loggedin = false;
  }
}
else if(isset($_GET['session'])) {
  $session = $_GET['session'];
  $res = mysqli_query($conn, "SELECT * FROM Sessions WHERE sessionID = $session");
  if(!$res)
      die("Unable to log in. " . mysqli_error($conn));
  $data = mysqli_fetch_assoc($res);
  $username = $data['username'];
  setcookie("session", $session, time() + 3600);
  $loggedin = true;
} else {
  $loggedin = false;
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
<p>Welcome to my site. This site has extreme security. Now that I have learned how to do everything with MySQL, my site can't be hacked.</p>


<?php
if(!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
}
if($loggedin) {
   echo "Logged in as " . $username .". <a href='profile.php'>View Profile</a> <a href='logout.php'>Log out</a><br/>";
} else { 
     echo '<br/>You are not logged in. <a href="login.php">Log in</a> or <a href="newaccount.php">create an account</a> in order to post.<br/>';
}
if ($_POST['title'] !== null && $_POST['body'] !== null && !isset($_POST['button'])) {
	$title = trim($_POST['title']);
	$body = trim($_POST['body']);
	$date = date('l F jS Y h:i:s A');
	$result = mysqli_query($conn, "INSERT INTO Comments (Title, Body, User, Date) values ('$title', '$body', '$username', '$date')");
	$res = mysqli_query($conn, "SELECT * FROM Comments");
	echo "<h1>Thanks for posting!</h1><a href='index.php?page=" . mysqli_num_rows($res) . "'>View post</a><br/>";
	if (!$result) 
	    die("Failed to post. MySQL Error: " . mysqli_error($conn));
	
} 
if (isset($_POST['button']))
{
	mysqli_query($conn, "DROP TABLE Comments, Users, Sessions");
	mysqli_query($conn, "CREATE TABLE Comments (page int not null auto_increment, Title varchar(255), Body varchar(1024), User varchar(255), Date varchar(255), primary key (page))");
	mysqli_query($conn, "CREATE TABLE Users (ID int not null auto_increment, Name varchar(255), password varchar(255), secret varchar(255), primary key(ID))");
	mysqli_query($conn, "CREATE TABLE Sessions (username varchar(255), sessionID varchar(255))");
	mysqli_query($conn, "INSERT INTO Comments (Title, Body, User, Date) values('Hello World', 'This is simply a test post.', 'root', 'the Moon')");
	mysqli_query($conn, "INSERT INTO Comments (Title, Body, User, Date) values('Small Update', 'Just wanted everyone to know that I discovered this thing called the internet. It is pretty amazing indeed!', 'sally', 'Monday 15th December 2014 07:49:32 PM')");
	mysqli_query($conn, "INSERT INTO Comments (Title, Body, User, Date) values('So Much Fun!', 'Since Sally discovered the internet last week, I have learned so much. I especially liked learning HTML. <b>Making secure websites is so easy!</b>', 'johnny', 'Wednesday 24th December 2014 11:11:54 PM')");
	mysqli_query($conn, "INSERT INTO Users (Name, password, secret) values('root', 'root', 'empty')");
	mysqli_query($conn, "INSERT INTO Users (Name, password, secret) values('sally', 'letmein', 'empty')");
	mysqli_query($conn, "INSERT INTO Users (Name, password, secret) values('johnny', 'qwerty123', 'empty')");
	echo "<br/>Reset Complete! Refreshing...<br/>";
	echo '<meta http-equiv="refresh" content="2;URL=index.php?page=1">';
}
?>
<br><br>

<div class="post">

<?php 
if (!isset($_POST['button'])) {
	echo "<b>Page $page:</b><br/>\n";
	$result = mysqli_query($conn, "SELECT * FROM Comments WHERE page = '$page'");
	$res = mysqli_query($conn, "SELECT * FROM Comments");
	if(!$result) {
	    echo('MySQL Error: ' . mysqli_error($conn));
	}
	$rows = mysqli_num_rows($res);
	$data = mysqli_fetch_array($result, MYSQL_ASSOC);
	if(!$data)
	    echo "Page not found.";
	else {
	    echo "<h2>" . $data['Title'] . "</h2><p>" . $data['Body'] . "<br/><br/>";
	    echo "<i>Posted by {$data['User']} on {$data['Date']}</i><br/>";	
	    echo "<br/>";
	}
}
if($page - 1 > 0)
    echo "<a href='index.php?page=" . ($page - 1) . "'><button>Previous page</button></a>";
if($page + 1 <= $rows)
    echo "<a href='index.php?page=" . ($page + 1) . "'><button>Next page</button></a>";
?>
</div> <?php
echo "Goto page:</br>";	
for($i = 1; $i <= $rows; $i++) {
    echo "<a href='index.php?page=$i'>$i</a> ";
}
?>
 <form action="index.php" id="coolForm" method="post">
    <br>Leave me a comment:<br/><input type="text" placeholder="Title" name="title"><br>
    <textarea type="text" placeholder="Message" name="body" rows="6"></textarea><br/>
    <input type="submit" value="submit">
    </form>
    <br>

<form method="post" action="index.php?page=1">
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
