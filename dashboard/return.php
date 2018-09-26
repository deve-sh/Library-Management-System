<?php
session_start();
include '../inc/config.php';
include 'admininc.php';
$bookid=$_GET['bookid'];
$gotuserid=$_GET['userid'];

if($_SESSION['userid']==""||$_SESSION['liblogin']==false)
  	{
  		header("refresh:1;url=../login.php");    
  		// Redirect user to the login page if not logged in.
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
<!DOCTYPE html>
<html>
<head>
	<title>Return Book</title>
	<?php include 'adminstyle.php'; ?>
</head>
<body onload="set()" onresize="set()">
   <?php
	if($_SESSION['libisadmin']!=true)
	  {
	  	echo "
	  	  <main>
	  	    <br>
	  	    <br>
	  	    &nbsp&nbsp&nbspYou are not authorised to view this page.
	  	  </main>";
	  	header("refresh:2;url=../index.php");
	  	exit();
	  }
	  else
	  {   // If the user is authorised.
	  	?>
	    <div id='topmenu' style="font-family: Roboto,sans-serif; background: #495057;">
	    <div class="topleft">
		   <a href='javascript:void(0)' onclick="openmenu()">
			  <i class="fas fa-bars" class='openmenu'></i>
		   </a>
		   &nbsp&nbsp
		   <?php echo "<i class='fas fa-book'></i>&nbsp&nbsp".$libname; ?>
	       </div>
			<div class='topright'>
				<a href="../search.php"><i class="fas fa-search"></i></a>
				&nbsp
			</div>
		</div>
		<div id="mySidenav" class="sidenav">
        <br/>
        <span class="closebtn" onclick="closeNav()">&times;</span>
	  <br/>
        <span class="closebtn" onclick="closeNav()">&times;</span>
	  	<?php
	  	  echo "<a href='../index.php'><i class='fas fa-home'></i> &nbsp&nbsp&nbspHome</a>";
	  	  echo "<a href='../usercp.php'><i class='fas fa-user-cog'></i> &nbsp&nbsp&nbspUser CP</a>";
     	  echo "<a href='../wishlist.php'><i class='fas fa-heart'></i> &nbsp&nbsp Wishlist</a>";
          echo "<a href='../logout.php'><i class='fas fa-user-slash'></i> &nbsp&nbsp Logout</a>";
        ?>
        
        <br/><br/>
		</div>
		<div class="main" align="center">
			<br/>
	<?php
	   if($bookid!="" && $gotuserid!="")
	   {
	   	  $query1=mysqli_query($dbcon,"SELECT * FROM ".$subscript."libbooks WHERE bookid='$bookid'");

	   	  $query2=mysqli_query($dbcon,"SELECT * FROM ".$subscript."libusers WHERE userid='$gotuserid'");

	   	  $query3=mysqli_query($dbcon,"SELECT * FROM ".$subscript."libissued WHERE userid='$gotuserid' AND bookid='$bookid'");

	   	  if(mysqli_num_rows($query1)!=0 && mysqli_num_rows($query2)!=0 && mysqli_num_rows($query3)!=0)
	   	  {
	   	  	 $book=mysqli_fetch_assoc($query1);
	   	  	 $iuser=mysqli_fetch_assoc($query2);
	   	  	 $issue=mysqli_fetch_assoc($query3);

	   	  	 if($issue['dor']=="")
	   	  	 {

	   	  ?>
	   	  <form class="loginform" action="" method='post' align='center'>
	   	  	<h3>Return Book</h3>
	   	  	<br/>
	   	  	<?php
	   	  	  echo "Book : ".$book['bookname'];
	   	  	  echo "<br>Username : ".$iuser['username'];
	   	  	  echo "<br>Date of Issue : ".$issue['doi'];

	   	  	  $today=date("Y-m-d");

	   	  	  echo "<br>Today : ".$today;
	   	  	?>
	   	  	<input type="num" name="fine" min='0' placeholder="Fine to be paid.">
	   	  	<br/><br/>
	   	  	<button type="submit">Return</button>
	   	  </form>
	   	  <?php
		   	  $fine=$_POST['fine'];
		   	  $fine_paid=1;

		   	  if($fine!="")
		   	  {
			   	  if($fine==0)
			   	  {
			   	  	$fine_paid=0;
			   	  	$query=mysqli_query($dbcon,"UPDATE ".$subscript."libissued SET dor='".$today."',fine='"."0"."',fine_paid='"."0"."'");
			   	  }
			   	  else if($fine<0)
			   	  {
			   	  	echo "<br>Invalid Input.";
			   	  }	
			   	  else
			   	  {
			   	  	$fine_paid=1;
			   	  	$query=mysqli_query($dbcon,"UPDATE ".$subscript."libissued SET dor='".$today."',fine='".$fine."',fine_paid='"."1"."' WHERE bookid='".$book['bookid']."' AND userid='".$iuser['userid']."'");

			   	  	if($query)
			   	  	{
			   	  		echo "<br/><br/>Returned book.";
			   	  		header("refresh:1;url=../dashboard");
			   	  		exit();
			   	  	}
			   	  	else
			   	  	{
			   	  		echo "<br/><br/>Could not return book. Kindly Try Again.";
			   	  	}
			   	  }
		   	  }
		   	}
		   	else
		   	{
		   		echo "<br/><br/>Book has already been returned.";
		   		header("refresh:2;url=../dashboard");
		   		exit();
		   	}
	   	  }
	   	  else
	   	  {
	   	  	echo "<br><br>The Issue does not exist.";
	   	  	header("refresh:2;url=../dashboard");
	   	  	exit();
	   	  }
	   }
	   ?>
	    <br><br>
	    <button><a href='../index.php'>Home</a></button> &nbsp&nbsp<button><a href="../dashboard">Admin CP</button>
	   <?
	}  // End
  ?>
  </div>
</body>
<script type="text/javascript">
	function set()
	{
		var firstheight=document.getElementById('topmenu').offsetHeight;

	    document.getElementsByClassName('main')[0].style.marginTop=""+firstheight+"px";
	    document.getElementById('topmenu').style.marginTop="-"+(firstheight)+"px";
	}

	var openmenu=function()
	{
		// Opening Function
		if(screen.width<700)
		{
		    document.getElementById("mySidenav").style.width = "100vw";
		}
		else
		{
			document.getElementById("mySidenav").style.width = '250px';
		}
	}

	function closeNav() {
	    document.getElementById("mySidenav").style.width = "0";
	}
</script>
</html>