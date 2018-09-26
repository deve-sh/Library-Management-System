<?php
session_start();
include 'inc/config.php';
include 'head.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $libname." - "; ?> Login</title>
	<? include 'inc/style.php'; ?>
</head>
<body style="background: linear-gradient(45deg, #ffffff 30%,#f2f2f2 30%); height: 100vh;">
<?php include 'header.php'; ?>
<br/><br/><br/>
<?php
if($_SESSION['liblogin']==true && $_SESSION['userid']!="")
{
	// If the user is already logged in, redirect them to the homepage with a message.
	echo "<br><br>&nbsp&nbsp&nbsp&nbspYou are already logged in. Kindly logout first.<br><Br>";
	header("refresh:2;url=index.php");
	exit();
}
else
{
?>
<div align="center" style="padding: 70px;">
	<form class="loginform" method="post">
		<h2>Login</h2>
		<br>
		<input type="text" name="username" required placeholder="Username or Email">
		<br><br>
		<input type="password" name="password" autocomplete="false" required placeholder="Password">
		<br><br>
		<button class='button'>Login</button>
		<span style='font-size: 15px;'>
		<?php
  // Logging In
  $username=$_POST['username'];
  $password=$_POST['password'];

  if($password!=""||$username!="")
  {
  	// If the password and username were entered.
    $query=mysqli_query($dbcon,"SELECT * FROM ".$subscript."libusers WHERE username='$username' OR email='$username'");

    if(mysqli_num_rows($query)==0 || mysqli_num_rows($query)>1)
    {
    	echo "<br><br>Sorry, no such user found, kindly try again.";
    }
    else
    {
    	$logginguser=mysqli_fetch_assoc($query);

    	$salt=$logginguser['salt'];

    	$password=crypt($password,$salt);
    	$password=md5($password);

    	$verifyquery=mysqli_query($dbcon,"SELECT * FROM ".$subscript."libusers WHERE (username='$username' OR email='$username') AND password='$password'");

    	$noofobtainedrows=mysqli_num_rows($verifyquery);

    	if($noofobtainedrows==1)
    	{
    		$loggeduser=mysqli_fetch_assoc($verifyquery);
    		// All the details of the user currently logging in.

            if($loggeduser['isbanned']==true)
            {
                echo "<br><br>You have been banned. Wait until the ban is lifted.";
            }
            else
            {
                echo "<br><br>You are successfully logged in.<br><br>You will be redirected to home.";
                $_SESSION['liblogin']=true;
                $_SESSION['userid']=$loggeduser['userid'];

                if($loggeduser['isadmin']==true)
                {
                    $_SESSION['libisadmin']=true;
                }
                header("refresh:3;url=index.php");
                exit();

            }
    	}
    	else
    	{
    		$_SESSION['liblogin']=false;
    		$_SESSION['userid']="";
    		$_SESSION['libisadmin']=false;
    		echo "<br><br>Wrong combination of username and password. Kindly try again.";
    	}
    }
  }
}  // End of logging in.
?>
</span>
	</form>
</div>
</body>
</html>