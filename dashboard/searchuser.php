<?php

include '../inc/config.php';

// PHP PAGE TO CHECK IF THE USERNAME BEING ENTERED WHILE SEARCHING IS VALID OR AVAILABLE.

$username=$_GET['username'];

if($username!="")
{
	$query=mysqli_query($dbcon,"SELECT * FROM ".$subscript."libusers WHERE username='$username' or email='$username'");

	if(mysqli_num_rows($query)==0)
	{
		echo "Username or Email Invalid.";
	}
	else
	{
		echo "1";
	}
}

?>