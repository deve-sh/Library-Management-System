<?php
session_start();
include 'inc/config.php';
include 'head.php';
$bookid=$_GET['bookid'];

if($_SESSION['libisadmin']==true && $bookid!="")
{
	$checkquery=mysqli_query($dbcon,"SELECT * FROM ".$subscript."libbooks WHERE bookid='$bookid'");

	if(mysqli_num_rows($checkquery)>0)
	{
		$wishlistdelete=mysqli_query($dbcon,"DELETE FROM ".$subscript."libwishlist WHERE bookid='$bookid'");   // DELETE FROM WISHLIST OF EVERY USER FIRST.

		$query=mysqli_query($dbcon,"DELETE FROM ".$subscript."libbooks WHERE bookid='$bookid'");
		if($query)
		{
			echo "Removed.";
		}
		else
		{
			echo "Couldn't remove.";
		}
	}
	else
	{
		echo "The post does not exist.";
	}
}
else
{
	echo "Unauthorised.";
	header("refresh:0;url=index.php");
	exit();
}
?>