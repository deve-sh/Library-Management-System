<?php
    if($_SESSION['userid']==""||$_SESSION['liblogin']==false)
  	{
  		header("refresh:1;url=login.php");    // Redirect user to the login page if not logged in.
  		exit();
  	}
  	else
  	{
  		$_SESSION['liblogin']=true;
  		$userid=$_SESSION['userid'];
  		$userquery=mysqli_query($dbcon,"SELECT * FROM ".$subscript."libusers WHERE userid='$userid'");

  		$user=mysqli_fetch_assoc($userquery);

  		if($user['isadmin']==true)
  		{
  			$_SESSION['libisadmin']=true;
  		}
  		else
  		{
  			$_SESSION['libisadmin']=false;
  		}
  	}
?>