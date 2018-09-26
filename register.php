<?php
session_start();
include 'inc/config.php';
include 'inc/saltgenerator.php';
include 'head.php';  // Checking the script is installed or not.
?>
<!DOCTYPE html>
<html>
<head>
	<title>Library Register</title>
	<? include 'inc/style.php'; ?>
</head>
<body style="background: linear-gradient(45deg, #ffffff 30%,#f2f2f2 30%); height: 100vh;">
<?php include 'header.php'; ?>
<br/><br/><br/>
<div align="center" style="padding: 70px;">
<?php
    if($_SESSION['liblogin']==false||$_SESSION['libisadmin']==false||$_SESSION['userid']=="")
    {
?>
	<form class="loginform" enctype="multipart/form-data" method="post" action="registering.php">   <!-- For sending files through the server.  -->
		<h2>Register</h2>
		<br>
		<input type="text" name="username" required placeholder="Username" onkeyup='checkusername(this.value)' onkeydown="checkusername(this.value)">  <!-- Sending the username to check. -->
		<span class='verifier' style="font-size: 13px;"></span>
		<br><br>
		<input type="text" name="name" required placeholder="Name" autocomplete="false">
		<br><br>
		<input type="password" name="password" required placeholder="Password">
		<br><br>
		<input type="text" name="email" required placeholder="Email">
		<br><br>
		<span style="font-size: 15px;">Upload Photo : </span><input type="file" name="image" required>
		<br><br>
		<button class='button'>Register</button>
	</form>
<?php
}
else
{
	echo "<br><br>&nbsp&nbsp&nbspYou are already logged in. Kindly logout first and then try registering.<br><br>
	<button><a href='index.php'>Home</a></div>";
}
?>
</div>
<script type="text/javascript">
	
		function checkusername(str)   // Check if the username is taken or not.
		{
			var request=new XMLHttpRequest();  // Creating a JSON Request.

			request.open('GET','check.php?string='+str,true);   // Opening the request page.

			request.onload=function()
			{
				var string=(request.responseText);
				document.getElementsByClassName('verifier')[0].innerHTML="<br><br>"+string.toString();
			}
			request.send();
		}
</script>
</body>
</html>