<?php

include '../inc/config.php';

$bookname=$_GET['bookname'];

if($bookname!="")
{
	$check=mysqli_query($dbcon,"SELECT * FROM ".$subscript."libbooks WHERE bookname='$bookname'");

	if(mysqli_num_rows($check)>0)
	{
		echo "Book Already Exists.";
	}
	else
	{
		echo "Book not in database. Go ahead.";
	}
}
?>