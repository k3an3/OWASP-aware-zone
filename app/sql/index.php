<?php
/* Allow init/reset from cli args */
if(isset($argv)) {
    parse_str(implode('&', array_slice($argv, 1)), $_GET);
}
/* Code to handle authentication check. */
$conn = mysqli_connect('localhost', 'username', 'password');
if(!$conn) {
  die('MySQL Error: ' . mysqli_error($conn));
}
mysqli_select_db($conn, 'sqldemo');
$loggedin = false;
/* If user has a cookie, check to see if the sessionID is in our database. If so, they are logged in. */
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
/* If the user doesn't have a cookie yet, see if a sessionID was sent as a GET variable.
If so, see if it exists in the database and then set a cookie granting login. */
if(isset($_GET['session']) && !$loggedin) {
  $session = $_GET['session'];
  $res = mysqli_query($conn, "SELECT * FROM Sessions WHERE sessionID = $session");
  if(!$res)
      die("Unable to log in. " . mysqli_error($conn));
  $data = mysqli_fetch_assoc($res);
  $username = $data['username'];
  if(isset($_COOKIE['session']))
      unset($_COOKIE['session']);
  setcookie("session", $session, time() + 3600);
  $loggedin = true;
}
?>
<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../css/demo.css" />
<link rel="shortcut icon" href="mat.ico">
<title>SQL Injection Demo</title>
</head>

<body>
<h1>Very Flashy and Complicated Website 3</h1>
<p>Welcome to my site. This site has extreme security. Now that I have learned how to do everything with MySQL, my site can't be hacked.</p>


<?php
/* Get the current page from the URL, otherwise it's page 1 */
if(!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
}
/* If the user is logged in, show profile and logout options, otherwise prompt for login or account creation. */
if($loggedin) {
   echo "Logged in as " . $username .". <a href='profile.php'>View Profile</a> <a href='logout.php'>Log out</a><br/>";
} else {
     echo '<br/>You are not logged in. <a href="login.php">Log in</a> or <a href="newaccount.php">create an account</a> in order to post.<br/>';
}

/* Runs if a user has submitted the comment form. The comment is then inserted into the database with username and date/time added. */
if ($_POST['title'] !== null && $_POST['body'] !== null && !isset($_POST['button'])) {
	$title = trim($_POST['title']);
	$body = trim($_POST['body']);
	$date = date('l F jS Y h:i:s A');
	$result = mysqli_query($conn, "INSERT INTO Comments (Title, Body, User, Date) values ('$title', '$body', '$username', '$date')");
	if (!$result)
	    die("Failed to post. MySQL Error: " . mysqli_error($conn));
	$res = mysqli_query($conn, "SELECT * FROM Comments");
	echo "<h1>Thanks for posting!</h1><a href='index.php?page=" . mysqli_num_rows($res) . "'>View post</a><br/>";
}

/* Runs if the reset button is pressed or the GET reset variable is set to true. Drops all database tables and rebuilds them from scratch, adding some sample users and comments.
Useful when the site has been nuked, or when setting up the demo for the first time. */
if (isset($_POST['button']) || $_GET['reset'] === 'true') {
	mysqli_query($conn, "DROP TABLE Comments, Users, Sessions");
	mysqli_query($conn, "CREATE TABLE Comments (page int not null auto_increment, Title varchar(255), Body varchar(1024), User varchar(255), Date varchar(255), test int, primary key (page))");
	mysqli_query($conn, "CREATE TABLE Users (ID int not null auto_increment, Name varchar(255), password varchar(255), secret varchar(255), datejoined varchar(255), numposts int, primary key(ID))");
	mysqli_query($conn, "CREATE TABLE Sessions (username varchar(255), sessionID varchar(255))");
	mysqli_query($conn, "INSERT INTO Comments (Title, Body, User, Date) values('Hello World', 'This is simply a test post.', 'root', 'Sunday 14th December 2014 06:35:22 PM')");
	mysqli_query($conn, "INSERT INTO Comments (Title, Body, User, Date) values('Small Update', 'Just wanted everyone to know that I discovered this thing called the internet. It is pretty amazing indeed!', 'sally', 'Monday 15th December 2014 07:49:32 PM')");
	mysqli_query($conn, "INSERT INTO Comments (Title, Body, User, Date) values('So Much Fun!', 'Since Sally discovered the internet last week, I have learned so much. I especially liked learning HTML and SQL. <b>Making secure websites is so easy!</b>', 'johnny', 'Wednesday 24th December 2014 11:11:54 PM')");
	mysqli_query($conn, "INSERT INTO Comments (Title, Body, User, Date) values('Hello Again', 'Just another little <i>test</i> by Johnny. I think something is wrong with this site...', 'nobody', 'the Moon')-- -', 'johnny', 'Wednesday 24th December 2014 11:52:01 PM')");
	mysqli_query($conn, "INSERT INTO Users (Name, password, secret, numposts, datejoined) values('root', 'root', 'I am root', '1', 'the past')");
	mysqli_query($conn, "INSERT INTO Users (Name, password, secret, numposts, datejoined) values('sally', 'letmein', 'Nobody tell my Mom that I found this...', '1', 'Monday December 15th 2014')");
	mysqli_query($conn, "INSERT INTO Users (Name, password, secret, numposts, datejoined) values('johnny', 'qwerty123', 'I think I may have hacked this site...', '1', 'Wednesday December 24th 2014')");
	echo "<br/><div class='msg'>Reset Complete! Refreshing...</div><br/>";
	echo '<meta http-equiv="refresh" content="2;URL=index.php?page=1">';
}
?>
<br><br>

<div class="post">

<?php
/* Display the post from the current page using database queries. Allows for multiple rows to be printed... */
if (!isset($_POST['button'])) {
	echo "<b>Page $page:</b><br/>\n";
	$result = mysqli_query($conn, "SELECT * FROM Comments WHERE page = '$page'");
	if(!$result) {
	    echo 'MySQL Error: ' . mysqli_error($conn) . '<br/>';
	}
	$res = mysqli_query($conn, "SELECT * FROM Comments");
	$rows = mysqli_num_rows($res);
	while($data = mysqli_fetch_assoc($result)) {
		echo "<h2>" . $data['Title'] . "</h2><p>" . $data['Body'] . "<br/><br/>";
		echo "<i>Posted by <a href='profile.php?user={$data['User']}'>{$data['User']}</a> on {$data['Date']}</i><br/>";
		echo "<br/>";
	}
}
/* Conditionally show previous and next page buttons. */
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
if($loggedin) { ?>
 <form action="index.php" id="coolForm" method="post">
    <br>Leave me a comment:<br/><input type="text" placeholder="Title" name="title"><br>
    <textarea type="text" placeholder="Message" name="body" rows="6"></textarea><br/>
    <input type="submit" value="submit">
    </form>
    <br>
<?php
}
?>

<form method="post" action="index.php?page=1">
    <p>
        <button name="button">Reset</button>
    </p>
</form>
<br>
<?php
echo '<a href="index.php?page=' . $page . '&hint=true">Hint</a>';
if(isset($_GET['hint'])) {
?>
<div class="hint">
<p>Notice the url bar when selecting a page. Looking at "index.php?page=1", the page number changes whenever we try to request a different page. This means that the value at the end
is being passed in as a GET variable. Oftentimes with this setup, an SQL database is what actually holds each page. Knowing this, an SQL command will need to be issued somewhere in
order to retrieve the page we want. Is the page number being directly inserted into an SQL command? If so, what happens when we replace the page number with SQL commands?</p>

<p>Since the posts are stored in a database, can we mess with the insert command if we add SQL commands to a post? Is there a way to escape the text and make it think you are
issuing part of the query? Look at the SQL queries in the code, and think about apostrophes. Keep in mind that you can use an SQL comment "-- -" to remove the rest of a query.</p>

<p>The posts might not be the only thing stored in the database. What else does the site need to keep track of?</p>
</div>
<?php
}
?>

<p style="font-size:10px"><a href="https://www.keaneokelley.com">Keane was here.</a></p>

</body>
</html>
