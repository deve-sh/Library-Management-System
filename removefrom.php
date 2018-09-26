<?php
  session_start();
  include 'inc/config.php';
  include 'head.php';

  $userid=$_GET['userid'];
  $bookid=$_GET['bookid'];

  if($_SESSION['userid']==$userid && $_SESSION['liblogin']==true && $bookid!="" && $userid!="")
  {
  	$query=mysqli_query($dbcon,"DELETE FROM ".$subscript."libwishlist WHERE bookid='$bookid' AND userid='$userid'");
  }
?>