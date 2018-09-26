<?php
session_start();
include 'inc/config.php';
include 'head.php';
$bookid=$_GET['bookid'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>View Book</title>
	<?php include 'inc/style.php'; ?>
</head>
<body onload="setheight()" onresize="setheight()">
<?php
  include 'header.php';
?>
<div class="main" style="padding: 25px;">
<?php
   if($bookid!="")
   {
    $extractquery=mysqli_query($dbcon,"SELECT * FROM ".$subscript."libbooks WHERE bookid='$bookid'");

    if(mysqli_num_rows($extractquery)==0)
    {
    	echo "<br><Br>No book found.";
    }
    else
    {
    	$book=mysqli_fetch_assoc($extractquery); 
    	echo "
        <div class='leftie'>
        <div class='left' align='center'>";
    	echo "<div class='bookheader'><h1>".$book['bookname']."</h1> - By ".$book['author']."<br><br></div>
    	<div class='imagebox'><img src='".$book['bookimage']."' class='fitimage' align='center'></div>";
    	echo "</div></div>";
    	echo "<div class='right'>";
    	echo "<span style='vertical-align:center;'>
    	<div id='rightbreak'></div>
    	    No of Copies : ".$book['noofcopies']."<br><br>
    	    ISBN : ".$book['isbn']."<br><br>
    	    Genre : ".$book['genre'];

    	if($_SESSION['liblogin']==true && $_SESSION['userid']!="")
    	{
    	echo "<br/><br/>
    	    <div class='button' onclick='addtowish(".$book['bookid'].")'><a href='javascript:void(0)'>Add to Wishlist</a></div> &nbsp&nbsp&nbsp
    	    ";
    	if($_SESSION['libisadmin']==true)
    	{
    		echo "
    	    <div class='remove' onclick='remove(".$book['bookid'].")'><a href='javascript:void(0)'>Remove</a></div>";
    	}

    	}
    	else
    	{
    		echo "<br><br>Login to add this book to your wishlist.";
    	}
    	echo "<br><br><button style='background : #454545'><a href='index.php'>Home</a></button>";
    	echo "
    	    </span>";
    	echo "</div>";

    }

   }
    else
    {
    	header("refresh:0;url=index.php");
    	exit();
    }
?>

<script type="text/javascript">
  function setheight()
  {
    var firstheight=document.getElementById('topmenu').offsetHeight;

    document.getElementsByClassName('main')[0].style.marginTop=""+firstheight+"px";
    document.getElementById('topmenu').style.marginTop="-"+(firstheight)+"px";

    if(screen.width>600)
    {
    	document.getElementById('rightbreak').innerHTML="<br><br><br>";
    }
    else
    {
    	document.getElementById('rightbreak').innerHTML="";
    }
  }
  function remove(str)    // Function to asyncnorously send data to the php page and remove a dataset from the database.
  {
    var removerequest=new XMLHttpRequest; 

    removerequest.open('GET','remove.php?bookid='+str);

    removerequest.onload=function()
    {
      console.log("1");
    }

    removerequest.send();

    location.reload();   // Reload the page from the cache.
  }

  function addtowish(str1)
  {
    var addrequest=new XMLHttpRequest;

    addrequest.open('GET','addtowish.php?bookid='+str1);

    addrequest.onload=function()
    {
      console.log('addtowish.php?bookid='+str1);
      console.log("1");
    }

    addrequest.send();

    location.reload();
  }

</script>
</div>
</body>
</html>