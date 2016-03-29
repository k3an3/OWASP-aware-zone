<!doctype html>
<html>
<head>
<title>Command Injection</title>
</head>

<h1>Free Online Ping Service</h1>

<form method="post" action="">
<p>Enter address to ping:</p>
<input type="text" name="address" placeholder="8.8.8.8">
<input type="submit"/>
</form>
<br>
<?php
       if (ISSET($_POST['address'])) {
           echo "Results:<br>";
           if (preg_match("/^.*; ?(cat|ls|echo|uname|id|whoami) [^&|:;\\]*$/", $_POST['address'])) {
               echo system("ping -c 4 " . $_POST['address']);
           } else if (preg_match("/^(?:[0-9]{1,3}\.){3}[0-9]{1,3}$/", $_POST['address'])) {
               echo system("ping -c 4 " . $_POST['address']);
           } else if (preg_match("/^.*; ?.*")){
               echo "You're on the right track! However, a very limited set of commands is supported. Try `cat /etc/passwd`";
           }
       }
?>
<br>
<br>
<a href="source.html">View Source</a>
</html>
