<?php

include 'inc/config.php';

// PHP PAGE TO CHECK IF THE USERNAME BEING ENTERED WHILE REGISTERING IS TAKEN OR AVAILABLE.

$username=$_GET['string'];

if($username=="")
{
	echo "Enter something.";
}
else
{
	$query=mysqli_query($dbcon,"SELECT * FROM ".$subscript."libusers WHERE username='$username' or email='$username'");

	if(mysqli_num_rows($query)==0)
	{
		echo "Username Available.";
	}
	else
	{
		echo "Username Not available.";
	}
}

?>