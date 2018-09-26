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
	<title>Add a Book Issue</title>
	<?php include 'adminstyle.php'; ?>
	<style type="text/css">
		.searcher{
			font-size: 12px;
		}
	</style>
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
	  	<?php
	  	  echo "<a href='../index.php'><i class='fas fa-home'></i> &nbsp&nbsp&nbspHome</a>";
	  	  echo "<a href='../dashboard/'><i class='fas fa-user-secret'></i> &nbsp&nbsp&nbspAdmin CP</a>";
	  	  echo "<a href='../usercp.php'><i class='fas fa-user-cog'></i> &nbsp&nbsp&nbspUser CP</a>";
     	  echo "<a href='../wishlist.php'><i class='fas fa-heart'></i> &nbsp&nbsp Wishlist</a>";
          echo "<a href='../logout.php'><i class='fas fa-user-slash'></i> &nbsp&nbsp Logout</a>";
        ?>
        
        <br/><br/>
		</div>
  <div class="main" align="center">
      	<?php
      	   if($bookid=="" && $gotuserid=="")
      	   {
      	   	?>
      	   	<br/><br/>
      	   	<form action="" method="post" class="loginform">
      	   		<h4>Add a Book Issue</h4>
      	   		<br/>
      	   		<input type="text" name="username" required onkeydown="searchuser(this.value)" onkeyup='searchuser(this.value)' id='username' placeholder="Username or Email">
      	   		<br/>
      	   		<span class="searcher"></span>
      	   		<br/>
      	   		<input type="text" onkeyup="searchbook(this.value)" onkeydown='searchbook(this.value)' name="bookname" required id='bookname' placeholder="Book Name Or ISBN">
      	   		<br/>
      	   		<span class="searcher"></span><br/>
      	   		<button type="submit" style="font-size: 12px;">ADD ISSUE</button>
      	   	</form>
      	   	<br/><br/>
      	   	<button><a href='../dashboard'>Back</a></button> &nbsp <button><a href="../index.php">Home</a></button>
      	   	<?php

      	   	$username=$_POST['username'];
      	   	$bookname=$_POST['bookname'];

      	   	if($bookname!="" && $username!="")
      	   	{
      	   		$checkquery1=mysqli_query($dbcon,"SELECT * FROM ".$subscript."libbooks WHERE bookname='$bookname' OR isbn='$bookname'");

      	   		$checkquery2=mysqli_query($dbcon,"SELECT * FROM ".$subscript."libusers WHERE username='$username' OR email='$username'");

      	   		if(mysqli_num_rows($checkquery1)>0 && mysqli_num_rows($checkquery2)>0)
      	   		{
      	   			$find1=mysqli_fetch_assoc($checkquery1);

      	   			$find2=mysqli_fetch_assoc($checkquery2);

      	   		    $checkquery3=mysqli_query($dbcon,"SELECT * FROM ".$subscript."libissued WHERE userid='".$find2['userid']."' AND bookid='".$find1['bookid']."'");

      	   		    $noofcopies=$find1['noofcopies'];

      	   		    $noalready=mysqli_num_rows(mysqli_query($dbcon,"SELECT * FROM ".$subscript."libissued where bookid=".$find1['bookid']));

      	   		    if(mysqli_num_rows($checkquery3)==0 && $noofcopies!=$noalready)
	      	   		{	
	      	   			$today=date("Y-m-d");  // Today's date.

	      	   			$insert1=mysqli_query($dbcon,"INSERT INTO ".$subscript."libissued VALUES('".$find1['bookid']."','".$find2['userid']."','$today',NULL,NULL,NULL)");

	      	   			if($insert1)
	      	   			{
	      	   				echo "<br/><br/>Successfully Added the Issue.";
	      	   			}
	      	   			else
	      	   			{
	      	   				echo "<br/><br/>
	      	   				".$find1['bookid']."<br/>".$find2['userid']."Could not add the Issue. Kindly Try Again Later.";
	      	   			}
      	   			}
      	   			else
      	   			{
      	   				echo "The user has already issued it, or the no of copies of the book are already over.";
      	   			}
      	   		}
      	   		else
      	   		{
      	   			echo "<br><br>Invalid Inputs.";
      	   		}
      	   	}
      	   }
      	?>
  </div>

  <?php
   }   // End
  ?>
  <script type="text/javascript" src="../scripts.js"></script>
<script type="text/javascript">
	function set()
	{
		    var firstheight=document.getElementById('topmenu').offsetHeight;

		    document.getElementsByClassName('main')[0].style.marginTop=""+firstheight+"px";
		    document.getElementById('topmenu').style.marginTop="-"+(firstheight)+"px";

	}

	function searchuser(str)
	{
		// Searching for the user using AJAX and PHP

		var searchu=new XMLHttpRequest();

		searchu.open('GET','searchuser.php?username='+str,true);

		searchu.onload=function()
		{
			if(searchu.responseText[0]=="1")
			{
				document.getElementById('username').style.borderBottom='1px solid green';
				document.getElementsByClassName('searcher')[0].textContent="";
			}
			else
			{
				document.getElementsByClassName('searcher')[0].textContent=searchu.responseText;

				document.getElementById('username').style.borderBottom='1px solid red';
			}

		}

		searchu.send();
	}

	function searchbook(st)
	{
		var searchb=new XMLHttpRequest();

		searchb.open('GET','searchbook.php?bookname='+st,true);

		searchb.onload=function()
		{
			if(searchb.responseText[0]=="1")
			{
				document.getElementById('bookname').style.borderBottom='1px solid green';
				document.getElementsByClassName('searcher')[1].textContent="";
			}
			else
			{
				document.getElementsByClassName('searcher')[1].textContent=searchb.responseText;
				document.getElementById('bookname').style.borderBottom='1px solid red';
			}
		}

		searchb.send();
	}
</script>
</body>
</html>