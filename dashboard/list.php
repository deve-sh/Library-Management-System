<?php
   session_start();
   include('../inc/config.php');
   include('admininc.php');

   $general=mysqli_fetch_assoc(mysqli_query($dbcon,"SELECT * FROM ".$subscript."libgen"));
?>
<!DOCTYPE html>
<html>
<head>
	<title>Issue Log</title>
	<?php include 'adminstyle.php'; ?>
</head>
<body>
	<?php
	  if($_SESSION['libisadmin']!=true)
	  {
	  	header("refresh:0;url=../index.php");
	  	exit();
	  }
	  else
	  {
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
		<div class="main">
			<br><br><br>
		<?php

		  	$extract=mysqli_query($dbcon,"SELECT * FROM ".$subscript."libissued");

		  	if(mysqli_num_rows($extract)==0)
		  	{
		  		echo "
		  		<br><br>
		  		<div align='center'><br><br>
    	      <i class='fas fa-address-book fa-3x' id='bigicon'></i>
    	      <br><br>
    	      No books in the issue list.</div>";;
		  	}
		  	else
		  	{
		  		while ($book=mysqli_fetch_assoc($extract)) {
		  			$userid=$book['userid'];
		  			$bookid=$book['bookid'];
		  			$booker=mysqli_fetch_assoc(mysqli_query($dbcon,"SELECT * FROM ".$subscript."libbooks WHERE bookid='$bookid'"));
		  			$userr=mysqli_fetch_assoc(mysqli_query($dbcon,"SELECT * FROM ".$subscript."libusers WHERE userid='$userid'"));
		  			echo "<div class='bookrow'>
		  			<div class='left'><a href='../viewbook.php?bookid=".$book['bookid']."' target='_blank'><img src='../".$booker['bookimage']."' width='50px' height='50px' style='border-radius : 50%;'> &nbsp&nbsp&nbsp".$booker['bookname']."</a> &nbsp&nbsp&nbsp &nbsp&nbsp&nbsp
             <span style='font-size : 14px;'><a href='viewuser.php?userid=".$userid."' target='_blank'>".$userr['username']."</a></span></div>
             <div class='right'>
             &nbsp&nbsp&nbsp".$userr['cardid']."&nbsp&nbsp&nbsp&nbsp".$book['doi'];

             if($book['dor']!="" && $book['fine_paid']!="")
             {
	            echo "&nbsp&nbsp&nbsp&nbsp".$book['dor'];	
             }
             else
             {
             	echo "&nbsp&nbsp&nbsp&nbsp<span class='button'><a href='return.php?bookid=".$booker['bookid']."&userid=".$userid."'>Return</a></span>";
             }
             echo "
             </div>";
		  		}
		  	}

		  	// END
		  }
	?>
</div>
<script type="text/javascript" src='../scripts.js'></script>
<script type="text/javascript">
	// In Page JavaScript
</script>
</body>
</html>