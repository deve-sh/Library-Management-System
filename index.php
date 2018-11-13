<?php
  session_start();

  include 'inc/config.php';
  
  // Redirect to installation page if the script is not yet installed.

  include 'head.php';
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
    $rowsperpage = 10;
    
    $totalpages = ceil($numrows / $rowsperpage);

    
    if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
       
       $currentpage = (int) $_GET['currentpage'];
    } else {
       
       $currentpage = 1;
    } 

    
    if ($currentpage > $totalpages) {
       
       $currentpage = $totalpages;
    } 
    
    if ($currentpage < 1) {
       
       $currentpage = 1;
    } 

    
    $offset = ($currentpage - 1) * $rowsperpage;

    $findbooks=mysqli_query($dbcon,"SELECT * FROM ".$subscript."libbooks LIMIT $offset, $rowsperpage");   

    // Extract 300 books at once if present.

    $numrows=mysqli_num_rows($findbooks);

    if($numrows==0)
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

      /* PAGINATION */

      echo "<br><br><div class='pagination' align='center'>";

      $range = 2;

      if($numrows>10)
      {
        if ($currentpage > 1) {
           
           echo "<a href='{$_SERVER['PHP_SELF']}?currentpage=1'><<</a> ";
           
           $prevpage = $currentpage - 1;
           
           echo "<a href='{$_SERVER['PHP_SELF']}?currentpage=$prevpage'><</a> ";
        } 

          
        for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
        
           if (($x > 0) && ($x <= $totalpages)) {
        
              if ($x == $currentpage) {
          
                 echo "<a class='active'>$x</a>";
              
              } else {
                 
                 echo "<a href='{$_SERVER['PHP_SELF']}?currentpage=$x'>$x</a> ";
              } 
           } 
        } 
                         
        
        if ($currentpage != $totalpages) {
           
           $nextpage = $currentpage + 1;
            
           echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$nextpage'>></a> ";
           
           echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$totalpages'>>></a> ";
        } 
      }
      echo "</div>";
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