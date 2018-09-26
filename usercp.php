<?php
session_start();
include 'inc/config.php';
include 'head.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>User CP</title>
	<?php include 'inc/style.php'; ?>
</head>
<body onload="set()" onresize="set()">
<?php
  include 'header.php';
?>
<div class="main">
	<br/><br/>
<?php
	if($_SESSION['liblogin']==false||$_SESSION['userid']==""){
	echo "Not logged in!";
	header("refresh:2;url=login.php");
	exit();
}
else{
	$userid=$_SESSION['userid'];
    $sql="SELECT * FROM ".$subscript."libusers WHERE userid='$userid'";
    $result=mysqli_query($dbcon,$sql);
    while($row=mysqli_fetch_assoc($result)){
    	echo "<div align='center'>
    	<br/>
    	Hey ".$row['name']."<br/><br/>
    	<img src ='".$row['image']."' width='100px' height='100px' style='border-radius:50%'></div><br><BR>";
echo "<div align='center'>
<ul>
	<li><a href='username.php?userid=".$userid."' style='color: #ffffff;'>Change Username</a></li><Br>
	<li><a href='email.php?userid=".$userid."' style='color: #ffffff;'>Change Email</a></li><br>
	<li><a href='photo.php?userid=".$userid."' style='color: #ffffff;'>Change Profile Photo</a></li><br>
	<li><a href='password.php?userid=".$userid."' style='color: #ffffff;'>Change Password</a></li><br>
</ul>
</div>
";
    }
}
?>

</div>
<script type="text/javascript" src='scripts.js'></script>
</body>
</html>