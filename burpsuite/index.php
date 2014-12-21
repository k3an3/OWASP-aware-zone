<!DOCTYPE HTML>
<html>
<head>
<link rel="shortcut icon" href="mat.ico">
<title>Burpsuite Test Site</title>
</head>

<body>
<h1>Very Flashy and Complicated Website</h1>
<p>Welcome to my site. I'm awesome d3veloper. My sites super securez.</p>
<p>How awesome I am??</p>

<script type="text/javascript">
function validate()
{
   var frm = document.forms["coolForm"];
   if( frm.cool.value == "" ) {
     alert( "You need to enter something first! Something that says I'm awesome!" );
     frm.cool.focus() ;
     return false;
   }
   if (frm.cool.value.toUpperCase().indexOf("AWESOME") == -1) {
	alert("You didn't mention that I'm awesome! Try Again!");
	return false;
	}
    return true;
}

</script>

<form action="test.php" id="coolForm" onsubmit="return (validate());" method="post">
Tell me that I'm awesome: <input type="text" name="cool">
<input type="submit" value="submit">
</form>
<form action="test.php" id="coolForm" method="post">
<input type="hidden" name="cool">
<input type="hidden" value="submit">
</form>
<br>
<img src="http://kbondale.files.wordpress.com/2014/06/matrix.gif" height=500 width=500/>
<form method="post">
    <p>
        <button name="button">Reset</button>
<?php
    if (isset($_POST['button']))
    {
         exec('cat /dev/null > list.txt');
		 echo "Reset Complete!";
    }
?>
</p></form>
<p style="font-size:10px">Keane was here.</p>


</html>