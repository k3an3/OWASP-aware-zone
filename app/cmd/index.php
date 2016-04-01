<!doctype html>
<html>
<head>
<title>Command Injection</title>
</head>

<h1>Free Online Ping Service</h1>

<form method="get" action="">
<p>Enter address to ping:</p>
<input type="text" name="address" placeholder="8.8.8.8">
<input type="submit"/>
</form>
<br>
<?php
if (ISSET($_REQUEST['address'])) {
    echo "Results:<br>";
    if (preg_match("/^.*; ?(ls|cat|echo|ping|grep|find|uname|id|whoami) ?[^|&;$()]*$/", $_REQUEST['address'])) {
        echo system("ping -c 4 " . $_REQUEST['address']);
    } else if (preg_match("/^(?:[0-9]{1,3}\.){3}[0-9]{1,3}$/", $_REQUEST['address'])) {
        echo system("ping -c 4 " . $_REQUEST['address']);
    } else if (preg_match("/^.*; ?.*$/", $_REQUEST['address'])){
        echo "You're on the right track! However, a very limited set of commands are supported. Try `cat /etc/passwd`";
    } else {
        echo "Something went horribly, horribly wrong.";
    }
}
?>
<br>
<br>
<a href="source.html">View Source</a>
</html>
