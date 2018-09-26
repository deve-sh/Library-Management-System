<?php
   session_start();
   include '../inc/config.php';
   include 'admininc.php';

   $userid=$_GET['userid'];
   
   $error=0;

   if($userid!="")
   {
   	$userquery=mysqli_query($dbcon,"SELECT * FROM ".$subscript."libusers WHERE userid='$userid'");

   	 if(mysqli_num_rows($userquery)==0){
   	 	$error++;
   	 }
   	 else
   	 {
   	 	$error=0;
   	 	$user=mysqli_fetch_assoc($userquery);
   	 }
   }
   else
   {
   	   $error=1;
   }
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php if($error==0){echo "User - ".$user['username'];}else{echo "View User";} ?></title>
	<?php include 'adminstyle.php'; ?>
</head>
<body onload="set()" onresize="set()">
<?php
  if($_SESSION['libisadmin']!=true || $_SESSION['liblogin']==false)
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
		<div class="main" align="center">
			<br/><br/><br/>
			<div class="usercard">
				<div class="usercardleft">
					<?php
					echo "<br><img src='../".$user['image']."' width='100px' height='100px' style='border-radius : 50%; vertical-align: center;'>";
					?>
				</div>
				<div class="usercardright">
					<?php
					   echo "<span style='vertical-align:center;'>";
					    echo "<h3>".$user['username']."</h3>";
					    if($user['name']!="")
					    {
					    	echo "<br>".$user['name'];
					    }
					    echo $user['name']."
					    <br>
					    ".$user['email']."<br><br><b>Card ID : </b>".$user['cardid'];
					   echo "</span>";
					?>
			</div>
		</div>
		<br>
		<br>
		<span class="button"><a href='viewusers.php'>Back</a></span>
		&nbsp&nbsp<span class="button"><a href="../dashboard">Admin CP</a></span>
		&nbsp&nbsp<span class="button"><a href="../index.php">Home</a></span>
	<?php
       }
    ?>
    <script type="text/javascript">
    	function set()
    	{
    		var firstheight=document.getElementById('topmenu').offsetHeight;

		    document.getElementsByClassName('main')[0].style.marginTop=""+firstheight+"px";
		    document.getElementById('topmenu').style.marginTop="-"+(firstheight)+"px";
    	}
    </script>
    <script type="text/javascript" src='../scripts.js'></script>
</body>
</html>