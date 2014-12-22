<!DOCTYPE HTML>
<html>
<head>
<title>Login</title>
</head>
<body>
<h1>Login</h1>
<?php
if($_POST['user'] === null || $_POST['pass'] === null) { ?>
<form method="post">
<p>Username:</p>
<input type="text" name="user">
<p><br/>Password:</p>
<input type="password" name="pass">
<input type="submit" value="Submit">
</form>

<?php }
else {
    $username = $_POST['user'];
    $password = $_POST['pass'];
    $conn = mysqli_connect('localhost', 'username', 'password');
    if (!$conn) 
	die("Failed to connect to MySQL: " . mysqli_error($conn));
    mysqli_select_db($conn, 'sqldemo');
    $result = mysqli_query($conn, "SELECT * FROM Users WHERE Name = '$username' AND password = '$password'");
    if(!$result)
	die("Could not find a user with that username and password combination.");
     session_name($username . time());
     session_start();
     echo "Logged in as " . $username . ". Redirecting...";
     echo "<meta http-equiv="refresh" content="0;URL=index.php">"
}
?>
</body>
</html>