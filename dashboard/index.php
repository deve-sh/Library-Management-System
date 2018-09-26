<?php
  session_start();
  include '../inc/config.php';
  include 'admininc.php';

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
	<title>Admin CP</title>
	<?php include 'adminstyle.php'; ?>
</head>
<body>
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
	  	  echo "<a href='../usercp.php'><i class='fas fa-user-cog'></i> &nbsp&nbsp&nbspUser CP</a>";
     	  echo "<a href='../wishlist.php'><i class='fas fa-heart'></i> &nbsp&nbsp Wishlist</a>";
          echo "<a href='../logout.php'><i class='fas fa-user-slash'></i> &nbsp&nbsp Logout</a>";
        ?>
        
        <br/><br/>
		</div>
		<div class='cp'>
		<br>
		<br>	
		<br>
		<a href='addbook.php'>	
		<div class="card">
			<div class="left" align="center">
				<i class="fas fa-plus fa-3x"></i>
			</div>
			
			<div class="right" align="center">
			   Add Book
		    </div>
		</div>
	    </a>
		<br/>
		<br/>

		<a href="addissue.php">
		  <div class="card">
			
			<div class="left" align="center" style="background: #d11f5d;">
				<i class="fas fa-list-ol fa-3x"></i>
			</div>
			
			
			<div class="right" align="center">
			   Add an Issue
		    </div>

		    </div>
	    </a>

	    <br/>
	    <br/>
	    
		<a href="list.php">
		<div class="card">
			
			<div class="left" align="center" style="background: #d9480f;">
				<i class="fas fa-address-book fa-3x"></i>
			</div>
			
			<div class="right" align="center">
			   View Issue Log
		    </div>

		    </div>
	    </a>
	    
	    <br><br>
	    
	    <a href="viewusers.php">
		  <div class="card">
			
			<div class="left" align="center" style="background: #82c91e;">
				<i class="fas fa-address-card fa-3x"></i>
			</div>
			
			
			<div class="right" align="center">
			   View  Users
		    </div>

		    </div>
	    </a>


	</div>


	<!-- End of frontend body -->

<script type="text/javascript">

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

        <?php
	  }
	?>
   
</body>
</html>
