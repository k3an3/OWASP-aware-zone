<!DOCTYPE HTML>
<html>
<head>
<title>Login</title>
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
     $session = intval(str_replace('.', '', $_SERVER['REMOTE_ADDR'])) * time() * 17 + $data['ID']; 
     $result = mysqli_query($conn, "INSERT INTO Sessions (username, sessionID) values('$username', '$session')");
     if (!$result) 
	die("Could not create a session. MySQL Error: " . mysqli_error($conn));
     echo "Logged in as " . $username . ". Redirecting...";
     echo '<meta http-equiv="refresh" content="0;URL=index.php?session=' . $session . '">';
}
?>
</body>
</html>