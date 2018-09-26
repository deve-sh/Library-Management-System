<?php
session_start();
include 'inc/config.php';
include 'head.php';   // Redirect to garbage if the script isn't installed.
?>
<!DOCTYPE html>
<html>
<head>
	<title>Search</title>
	<?php include 'inc/style.php'; ?>
</head>
<body onload='set()' onresize="set()">
	<?php include 'header.php'; ?>
	<div class="main" style="padding: 20px;">
	<form action="" method="post" align='center'> 
		<br>
		<input type="text" name="searchkey" required placeholder="Enter the Book Or Author to Search For" /><br>
		<br><button type="submit">Search</button>&nbsp&nbsp<button><a href="index.php">Home</a></button>
		<br><br>
	</form>

	<?php
	   $searchkey=$_POST['searchkey'];

	   if($searchkey!="")
	   {
	   	$search=mysqli_query($dbcon,"SELECT * FROM ".$subscript."libbooks WHERE bookname LIKE '%".$searchkey."%' OR author LIKE '%".$searchkey."%'");

	   	if(mysqli_num_rows($search)==0)
	   	{
	   		echo "Nothing found!";
	   	}
	   	else
	   	{
	   		while($book=mysqli_fetch_assoc($search))
	   		{
	   			echo "<div class='bookrow'>
          <a href='viewbook.php?bookid=".$book['bookid']."'>
           <div class='left'>
             <img src='".$book['bookimage']."' width='50px' height='50px' style='border-radius : 50%;'> &nbsp&nbsp&nbsp".$book['bookname']." &nbsp&nbsp&nbsp
             <span style='font-size : 12px;'>".$book['author']."</span>
           </div>
           </a>
           <div class='right'>";
           if($_SESSION['libisadmin']==true)
           {
            echo "<span class='remove' bookid='".$book['bookid']."' onclick='remove(".$book['bookid'].")'>Remove</span> &nbsp&nbsp ";
           }

           if($_SESSION['liblogin']==true)
           {
            echo "<span id='userid' style='display: none;'>".$_SESSION['userid']."</span>";
           }

           if($_SESSION['liblogin']==true  && mysqli_num_rows(mysqli_query($dbcon,"SELECT * FROM ".$subscript."libwishlist WHERE userid='".$_SESSION['userid']."' AND bookid='".$book['bookid']."'"))==0)
           {
           echo "<span class='button' bookid='".$book['bookid']."' onclick=addtowish(".$book['bookid'].") title='Add to Wishlist'><i class='fas fa-heart'></i></span>";
           }
           else if($_SESSION['liblogin']==true && mysqli_num_rows(mysqli_query($dbcon,"SELECT * FROM ".$subscript."libwishlist WHERE userid='".$_SESSION['userid']."' AND bookid='".$book['bookid']."'"))>0)
           {
            echo "<span class='button' bookid='".$book['bookid']."' onclick=removefrom(".$book['bookid'].") title='Remove From Wishlist'><i class='far fa-times-circle'></i></span>";
           }
           echo "
           </div>
           
        </div>";
	   		}
	   	}
	   }
	?>
</div>
<script type="text/javascript">
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

  function set()
  {
    var firstheight=document.getElementById('topmenu').offsetHeight;

    document.getElementsByClassName('main')[0].style.marginTop=""+firstheight+"px";
    document.getElementById('topmenu').style.marginTop="-"+(firstheight)+"px";
  }

  function removefrom(str)
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