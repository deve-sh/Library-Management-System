<?php

include '../inc/config.php';

// PHP PAGE TO CHECK IF THE bookname BEING ENTERED WHILE SEARCHING IS VALID OR AVAILABLE.

$bookname=$_GET['bookname'];

if($bookname!="")
{
	$query=mysqli_query($dbcon,"SELECT * FROM ".$subscript."libbooks WHERE bookname='$bookname' OR isbn='$bookname'");

	if(mysqli_num_rows($query)==0)
	{
		echo "Book Name Invalid.";
	}
	else
	{
		echo "1";
	}
}

?>