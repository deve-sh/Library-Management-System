<?php
session_start();
include 'inc/config.php';
include 'head.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Library - Wishlist</title>
	<? include 'inc/style.php'; ?>
</head>
<body>
	<?php
	   include 'loggedin.php';
	?>
 <div id="mySidenav" class="sidenav">
  <br/>
  <span class="closebtn" onclick="closeNav()">&times;</span>
  <?php
     echo "<a href='index.php'><i class='fas fa-home'></i> &nbsp&nbsp&nbspHome</a>";
     if($_SESSION['liblogin']!=true)
     {
     	echo "<a href='login.php'><i class='fas fa-user'></i> &nbsp&nbsp&nbspLogin</a>";
     	echo "<a href='register.php'>Register</a>";
     }
     else
     {
     	if($_SESSION['libisadmin']==true)
     	{
     	echo "<a href='dashboard/'><i class='fas fa-user-secret'></i> &nbsp&nbsp&nbspAdmin CP</a>";
     	}
     	echo "<a href='usercp.php'><i class='fas fa-user-cog'></i> &nbsp&nbsp&nbspUser CP</a>";
     	echo "<a href='logout.php'><i class='fas fa-user-slash'></i> &nbsp&nbsp Logout</a>";
     }
  ?>
</div>

<div id='topmenu' style="font-family: Roboto,sans-serif;">
	<div class="topleft">
		<a href='javascript:void(0)' onclick="openmenu()">
			<i class="fas fa-bars" class='openmenu'></i>
		</a>
		&nbsp&nbsp
		<?php echo "<i class='fas fa-book'></i>&nbsp&nbsp".$libname." - Wishlist"; ?>
	</div>
	<div class='topright'>
		<a href="search.php"><i class="fas fa-search"></i></a>
		&nbsp
	</div>
</div>
<script type="text/javascript" src='scripts.js'></script>
	<?
	   echo "<br><br><br>";
	?>
	<div class="main">
		<?php
		  $userid=$_SESSION['userid'];
		  
		  $findbooks=mysqli_query($dbcon,"SELECT * FROM ".$subscript."libwishlist WHERE userid='$userid'");

		  $noofbooks=mysqli_num_rows($findbooks);

		  if($noofbooks==0)
		  {
		  	  echo "<div align='center'><br><br>
    	      <i class='fas fa-heart fa-3x' id='bigicon'></i>
    	      <br><br>
    	      No books in your Wishlist.</div>";
		  }
		  else
		  {
		  	  while($book=mysqli_fetch_assoc($findbooks))
	   		{
	   			$booker=mysqli_fetch_assoc(mysqli_query($dbcon,"SELECT * FROM ".$subscript."libbooks WHERE bookid=".$book['bookid'].""));
	   			echo "<div class='bookrow'>
          <a href='viewbook.php?bookid=".$book['bookid']."'>
           <div class='left'>
             <img src='".$booker['bookimage']."' width='50px' height='50px' style='border-radius : 50%;'> &nbsp&nbsp&nbsp".$book['bookname']." &nbsp&nbsp&nbsp
             <span style='font-size : 12px;'>".$book['author']."</span>
           </div>
           </a>
           <div class='right'>";
           if($_SESSION['liblogin']==true)
           {
           echo "<span class='remove' bookid='".$book['bookid']."' onclick=removefromwishlist(".$book['bookid'].") title='Remove From Wishlist'>Remove</span>";
           }
           echo "
           </div>
        </div>
        <span id='userid' style='display: none'>".$_SESSION['userid']."</span>";
        }
		  }
		?>
	</div>
  <script type="text/javascript">
    function set()
    {
        var firstheight=document.getElementById('topmenu').offsetHeight;

        document.getElementsByClassName('main')[0].style.marginTop=""+firstheight+"px";
        document.getElementById('topmenu').style.marginTop="-"+(firstheight)+"px";
    }

    function removefromwishlist(str)
    {
        var request=new XMLHttpRequest;

        var userid=document.getElementById('userid').textContent;

        request.open('GET','removefrom.php?userid='+userid+"&bookid="+str);

        request.onload=function()
        {
          console.log("Complete");
        }

        request.send();

        location.reload(true);
    }
  </script>
</body>
</html>