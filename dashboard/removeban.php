<?php
session_start();
include '../inc/config.php';
include 'admininc.php';

$userid=$_GET['userid'];

if($userid!="" && $_SESSION['libisadmin']==true)
{
	$check=mysqli_query($dbcon,"SELECT * FROM ".$subscript."libusers WHERE userid='$userid'");

	if(mysqli_num_rows($check)>0)
	{
		$usertoban=mysqli_fetch_assoc($check);
	}

	if($usertoban['isbanned']==1 && $usertoban['isadmin']==false)
	{
		$banquery=mysqli_query($dbcon,"UPDATE ".$subscript."libusers SET isbanned=0 WHERE userid='$userid'");
	}
}
?>