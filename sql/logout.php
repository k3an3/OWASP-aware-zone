<!DOCTYPE HTML>
<html>
<body>
<?php 
if(isset($_COOKIE['session'])) {
    $conn = mysqli_connect('localhost', 'username', 'password');
    if (!$conn) 
	die("Failed to connect to MySQL: " . mysqli_error($conn));
    mysqli_select_db($conn, 'sqldemo');
    $result = mysqli_query($conn, "Select * FROM Sessions WHERE sessionID = '{$_COOKIE['session']}'");
    $data = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result) == 0) 
	 die("User does not appear to be logged in.");
    $username = $data['username'];
    $result = mysqli_query($conn, "DELETE FROM Sessions WHERE username = '$username'");
    if(!$result)
	die("Could not log you out. " . mysqli_error($conn));
    echo "You have been successfully logged out. Redirecting...";
    echo '<meta http-equiv="refresh" content="2;URL=index.php">';
}
?>
</body>
</html>