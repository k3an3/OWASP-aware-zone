<!DOCTYPE HTML>
<html>
<head>
<title>Account Creation</title>
</head>
<body>
<h1>Create an Account</h1>
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
    $result = mysqli_query($conn, "Select * FROM Users WHERE Name = '$username'");
    $data = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result) != 0) 
	 die("<br/>A user with that username already exists. Try again.");
    $date = date('l F jS Y');
    $result = mysqli_query($conn, "INSERT INTO Users (Name, Password, Secret, numposts, datejoined) VALUES('$username', '$password', 'None', 0, '$date')");
    if(!$result)
	die("Failed to add user. MySQL Error: " . mysqli_error($conn));
    echo 'User added successfully! You may now proceed to <a href="login.php">login</a>.';
}
?>
</body>
</html>