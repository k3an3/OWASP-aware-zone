<!DOCTYPE HTML>
<html>
<head>
<title>Account Creation</title>
</head>
<body>
<h1>Create an Account</h1>
<?php
if($_POST['user'] === null || $_POST['pass'] === null) { ?>
<form method="post">
<p>Username:</p>
<input type="text" name="user">
<p><br/>Password:</p>
<input type="text" name="pass">
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
    $result = mysqli_query($conn, "INSERT INTO Users (Name, Password, Secret) VALUES($username, $password, 'None')");
    if(!$result)
	die("Failed to add user. MySQL Error: " . mysqli_error($conn));
    echo 'User added successfully! You may now proceed to <a href="login.php">login</a>.';
}
?>
</body>
</html>