<?php
session_start();
include 'inc/config.php';

$bookid=$_GET['bookid'];


if($_SESSION['liblogin']==true && $bookid!="")
{
	$userid=$_SESSION['userid'];

	$checkquery=mysqli_query($dbcon,"SELECT * FROM ".$subscript."libbooks WHERE bookid='$bookid'");

	if(mysqli_num_rows($checkquery)>0)
	{
		$booker=mysqli_fetch_assoc($checkquery);
		$bookname=$booker['bookname'];
		$author=$booker['author'];

		$checkquery2=mysqli_query($dbcon,"SELECT * FROM ".$subscript."libwishlist WHERE userid='$userid' AND bookid='$bookid'");

		if(mysqli_num_rows($checkquery2)<1)   
		// I.E : If the user doesn't already have the book in his/her wishlist.
		{
			$additionquery=mysqli_query($dbcon,"INSERT INTO ".$subscript."libwishlist VALUES('$userid','$bookid','$bookname','$author')");

			if($additionquery)
			{
				echo "Addition successful.";
			}
			else
			{
				echo "Addition Unsuccessful.";
			}
		}
		else
		{
			echo "Book already in wishlist.";
		}
	}
	else
	{
		echo "Book does not exist.";
	}
}
else
{
	header("refresh:0;url=index.php");
	exit();
}
?>