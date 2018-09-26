<?php
session_start();
include '../inc/config.php';
include 'admininc.php';
$pageid=$_GET['pageid'];

if($pageid=="")
{
	$pageid=0;
}
$lower=$pageid*100;
$upper=$lower+100;
?>
<!DOCTYPE html>
<html>
<head>
	<title>View Users</title>
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
		    $userquery=(mysqli_query($dbcon,"SELECT * FROM ".$subscript."libusers"));

		    $noofusers=mysqli_num_rows($userquery);

		    if(mysqli_num_rows($userquery)==0)
            {
		    	echo "<div align='center'><br><br>
		    	<i class='fas fa-book fa-3x' id='bigicon'></i>
		    	<br><br>
		    	No users of the library.</div>";
             }
             else
             {
             	while($users=mysqli_fetch_assoc($userquery))  // Printing the details of the books one by one.
    	{
        echo "
        <div class='bookrow'>
          <a href='viewuser.php?userid=".$users['userid']."'>
           <div class='left'>
             <img src='../".$users['image']."' width='50px' height='50px' style='border-radius : 50%;'> &nbsp&nbsp&nbsp".$users['name']." &nbsp&nbsp&nbsp
             <span style='font-size : 12px;'>".$users['username']."</span>
           </div>
           </a>
           <div class='right'>";
           if($users['isbanned']==false && $users['isadmin']==false)
           {
            echo "<span class='remove' userid='".$users['userid']."' onclick='ban(".$users['userid'].")'>Ban</span> &nbsp&nbsp ";
           }
           else if($users['isbanned']==true)
           {
           	echo "<span class='button' userid='".$users['userid']."' onclick='removeban(".$users['userid'].")'>Lift Ban</span> &nbsp&nbsp ";
           }
           echo "
           </div>
           
        </div>";
    	}

    	if($pageid>0)
    	{
    		$nextpage=$pageid+1;
    		$previouspage=$pageid-1;
    		$homepage=0;
?>
            <div align="center"><div>
            	<?php
            	    echo "<a href='index.php?pageid=".$homepage."'>Home</a>&nbsp&nbsp<a href='index.php?pageid=".$previouspage."'>Previous</a>"; 
            	    if($noofusers==300)   // If the no of books is in fact equal to or more than 299.
            	   	{
            	   	    echo "&nbsp&nbsp<a href='index.php?pageid=".$nextpage."'>Next</a>";
            	   	}
            	?>
            </div></div>
<?php
    	}
    	else if($pageid==0)
    	{
    		if($noofusers==300)   // If the no of books was in fact equal to 299 or more than it, i.e : 300.
    		{
    			$nextpage=$pageid+1;
?>
            <div align="center"><div>
            	<?php
            	    echo "<a href='index.php?pageid=".$nextpage."'>Next</a>";
            	?>
            </div></div>
<?php

    		}
    	}

?>

<?php
             }
         }

		?>
	    </div>
<!--- Page Functioning JavaScript  -->
	    <script type="text/javascript">
		  function set()
		  {
		  	
		  	// TO SET THE HEIGHT AND WIDTH OF THE PAGE APPROPRIATELY.

		    var firstheight=document.getElementById('topmenu').offsetHeight;

		    document.getElementsByClassName('main')[0].style.marginTop=""+firstheight+"px";
		    document.getElementById('topmenu').style.marginTop="-"+(firstheight)+"px";
		  }
	      
	      function ban(str)
	      {
	      	// AJAX CALLS START HERE

	      	var banrequest=new XMLHttpRequest;

	      	banrequest.open('GET','ban.php?userid='+str,true);

	      	banrequest.onload=function()
	      	{
	      		console.log("1");
	      	}

	      	banrequest.send();

	      	location.reload();
	      }

	      function removeban(stri)
	      {
	      	var removerequest=new XMLHttpRequest();

	      	removerequest.open('GET','removeban.php?userid='+stri,true);

	      	removerequest.onload=function()
	      	{
	      		console.log("1");
	      	}

	      	removerequest.send();

	      	location.reload();
	      }


	      // END OF PAGE EXECUTION

	    </script>
	    <script type="text/javascript" src='../scripts.js'></script>
</body>
</html>