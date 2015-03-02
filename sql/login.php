<!DOCTYPE HTML>
<html>
<head>
<title>Login</title>
<link rel="stylesheet" type="text/css" href="../css/demo.css" />
</head>
<body>
<h1>Login</h1>
<form method="post">
<p>Username:</p>
<input type="text" name="user">
<p><br/>Password:</p>
<input type="password" name="pass">
<input type="submit" value="Submit">
</form>

<?php 
/* Grab login information from POST. Check to see if there is a matching username and password in the database. If so, generate a unique sessionID and save it in the Sessions table.
Otherwise, let the user know they can't log in. */
if($_POST['user'] !== null || $_POST['pass'] !== null) {
    $username = $_POST['user'];
    $password = $_POST['pass'];
    $conn = mysqli_connect('localhost', 'username', 'password');
    if (!$conn) 
	die("Failed to connect to MySQL: " . mysqli_error($conn));
    mysqli_select_db($conn, 'sqldemo');
    $result = mysqli_query($conn, "SELECT * FROM Users WHERE Name = '$username' AND password = '$password'");
    if(mysqli_num_rows($result) == 0)
	die("<br/>Could not find a user with that username and password combination.");
     $data = mysqli_fetch_assoc($result);
     $session = intval(str_replace('.', '', $_SERVER['REMOTE_ADDR'])) / 10000000 * time() * 17 + $data['ID']; 
     $result = mysqli_query($conn, "INSERT INTO Sessions (username, sessionID) values(\"$username\", \"$session\")");
     echo "Logged in as " . $username . ". Redirecting...";
     echo '<meta http-equiv="refresh" content="0;URL=index.php?session=' . $session . '">';
}
echo '<br/><a href="login.php?hint=true">Hint</a>';
if(isset($_GET['hint'])) {
?>
<div class="hint">
It is very likely that the Users are stored in the database. Is there any way to trick the website into thinking we should be able to log in?
</div>
<?php
}
?>
</body>
</html>
