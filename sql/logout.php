<!DOCTYPE HTML>
<html>
<body>
<?php 
/* See if user is logged in with a session cookie. If so, find their session in the database to confirm that it exists. If so, delete all of that user's sessions from the 
table (harsh logout behaviour) and attempt to clear the session cookie, effectively logging them out. */
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
    unset($_COOKIE['session']);
    if(!$result)
	die("Could not log you out. " . mysqli_error($conn));
    echo "You have been successfully logged out. Redirecting...";
    echo '<meta http-equiv="refresh" content="2;URL=index.php">';
}
?>
</body>
</html>