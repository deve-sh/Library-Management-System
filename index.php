<?php
  session_start();

  include 'inc/config.php';
  
  // Redirect to installation page if the script is not yet installed.

  include 'head.php';
  
  $pageid=$_GET['pageid'];
  
  // But if there is no page id.

  if(empty($pageid))
  {
  	$pageid=0;
  }

  $lowerlimit=$pageid*300;
  $upperlimit=$lowerlimit+300;
?>
<html>
<head>
	<title><?php echo $libname; ?></title>

	<?php include 'inc/style.php'; ?>
</head>
<?php
    include 'header.php';
?>
<body onload="set()" onresize="set()">
<div class="main">
<br>
<?php
    $findbooks=mysqli_query($dbcon,"SELECT * FROM ".$subscript."libbooks LIMIT ".$lowerlimit.",".$upperlimit."");   

    // Extract 300 books at once if present.

    $noofbooks=mysqli_num_rows($findbooks);

    if($noofbooks==0)
    {
    	echo "<div align='center'><br><br>
    	<i class='fas fa-book fa-3x' id='bigicon'></i>
    	<br><br>
    	We're sorry, but currently there are no books in the segment.</div>";
    }
    else
    {

    	while($book=mysqli_fetch_assoc($findbooks))  // Printing the details of the books one by one.
    	{
        echo "
        <div class='bookrow'>
          <a href='viewbook.php?bookid=".$book['bookid']."'>
           <div class='left'>
             <img src='".$book['bookimage']."' width='50px' height='50px' style='border-radius : 50%;'> &nbsp&nbsp&nbsp".$book['bookname']." &nbsp&nbsp&nbsp
             <span style='font-size : 12px;'>".$book['author']."</span>
           </div>
           </a>
           <div class='right'>";
           if($_SESSION['liblogin']==true)
           {
            $query2=mysqli_query($dbcon,"SELECT * FROM ".$subscript."libwishlist WHERE userid=".$_SESSION['userid']." AND bookid=".$book['bookid']."");

            if(mysqli_num_rows($query2)==0)
            {
               echo "<span class='button' bookid='".$book['bookid']."' onclick=addtowish(".$book['bookid'].") title='Add to Wishlist'><i class='fas fa-heart'></i></span> &nbsp&nbsp&nbsp";
            }
           }
           if($_SESSION['libisadmin']==true)
           {
            echo "<span class='remove' bookid='".$book['bookid']."' onclick='remove(".$book['bookid'].")'>Remove</span> &nbsp&nbsp ";
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
            	    if($noofbooks==300)   // If the no of books is in fact equal to or more than 299.
            	   	{
            	   	    echo "&nbsp&nbsp<a href='index.php?pageid=".$nextpage."'>Next</a>";
            	   	}
            	?>
            </div></div>
<?php
    	}
    	else if($pageid==0)
    	{
    		if($noofbooks==300)   // If the no of books was in fact equal to 299 or more than it, i.e : 300.
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
?>
</div>
<div class="footer">
  Coded with <i class="fas fa-heart"></i> by <a href="https://deve-sh.github.io/website" target="_blank">Devesh Kumar</a>.
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

    location.reload(true);   // Reload the page from the cache.
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

    location.reload(true);
  }

  function set()
  {
    var firstheight=document.getElementById('topmenu').offsetHeight;

    document.getElementsByClassName('main')[0].style.marginTop=""+firstheight+"px";
    document.getElementById('topmenu').style.marginTop="-"+(firstheight)+"px";

    if((document.getElementsByClassName('main')[0].offsetHeight-document.getElementById('topmenu').offsetHeight)<window.innerHeight)
    {
      document.getElementsByClassName('main')[0].style.height=window.innerHeight-document.getElementById('topmenu').offsetHeight;
    }
  }
</script>
</body>
</html>