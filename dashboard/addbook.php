<?php
  session_start();
  include('../inc/config.php');
  include 'admininc.php';

    if($_SESSION['userid']==""||$_SESSION['liblogin']==false)
  	{
  		header("refresh:1;url=../login.php");    // Redirect user to the login page if not logged in.
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
	<title>Add a book</title>
	<?php include 'adminstyle.php'; ?>
</head>
<body style="background: linear-gradient(45deg, #ffffff 30%,#f2f2f2 30%); height: 100vh;">
<?php
	  if($_SESSION['libisadmin']!=true)
	  {   // If the user is not authorised.
	  	echo "
	  	  <div align='center' style='padding : 70px;'>
	  	    <br>
	  	    <br>
	  	    &nbsp&nbsp&nbspYou are not authorised to view this page.
	  	  </div>";
	  	header("refresh:2;url=../index.php");
	  	exit();
	  }
	  else{   // If the user is authorised.
	  	?>
	  </div>
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
		<div align="center" style="padding : 70px;">
			<br><br>
	  	<!-- Book adding form  -->
	  	<form class="loginform" enctype="multipart/form-data" method="post" action="">
	  		<div align="center"><h3>Add a book</h3></div>
	  		<br>
	  		<input type="text" name="bookname" onkeyup="checkbook(this.value)" onkeydown="checkbook(this.value)" required="required" placeholder="Book Name">
	  		<span id='verifier' style="font-size: 15px;"></span>
	  		<br><br>
	  		<input type="text" name="author" required placeholder="Author">
	  		<br><br>
	  		<input type="text" name="genre" placeholder="Genre">
	  		<br><br>
	  		<input type="text" name="type" required placeholder="Type" />
	  		<br><br>
	  		<input type="text" name="isbn" placeholder="ISBN">
	  		<br><br>
	  		<input type="number" min="1" name="noofcopies" placeholder="No of Copies"><br><br>
	  		<input type="number" min="0" name="nissues" placeholder="No Of Issues"><br><br>
	  		Image of Book : <input type="file" name="image" required>
	  		<br><br>
	  		<button type="submit" name="submit">ADD BOOK</button>
	  	</form>
	  	<br><br>
	  	<?php
	  	// Start of addition to the database.

	  	$bookname=$_POST['bookname'];
	  	$author=$_POST['author'];
	  	$genre=$_POST['genre'];
	  	$type=$_POST['type'];
	  	$isbn=$_POST['isbn'];
	  	$noofcopies=$_POST['noofcopies'];
	  	$nissues=$_POST['nissues'];

	  	if(isset($_POST['submit']) && $bookname!="" && $author!="" && $genre!="" && $type!="" && $isbn!="" && $noofcopies>0 && $nissues>=0)
	  	{
	  		$checkquery=mysqli_query($dbcon,"SELECT * FROM ".$subscript."libbooks WHERE bookname='$bookname'");

	  		if(mysqli_num_rows($checkquery)>0)
	  		{
	  			echo "<Br><br>Book already exists.";
	  		}
	  		else
	  		{
	  			// FILE UPLOAD NOW
	  			$target_dir = "../uploads/";

			$target_file = basename($_FILES["image"]["name"]);

			$target_filed = "../uploads/".$target_file;

			$uploadOk = 1;

			$imageFileType = strtolower(pathinfo($target_filed,PATHINFO_EXTENSION));

			// Check if image file is a actual image or fake image
			
			if(isset($_POST["submit"])) {
			    $check = getimagesize($_FILES["image"]["tmp_name"]);
			    if($check !== false) {
			        $uploadOk = 1;
			    } else {
			        echo "File is not an image.";
			        $uploadOk = 0;
			    }
			}
			// Check if file already exists
			if (file_exists($target_filed)) {
				$rand=rand(1,10000000000);
				$target_file = basename($_FILES["image"]["name"]);
				$ext=end(explode(".",$target_file));
				$filename=basename($target_file,".".$ext);
				$filename=$filename.$rand;
			    $target_file=$filename.".".$ext;
			    $target_filed= "../uploads/".$target_file;
			}
			// Check file size
			if ($_FILES["image"]["size"] > 500000) {
			    echo "Sorry, your file is too large.";
			    $uploadOk = 0;
			}
			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" && $imageFileType!="bmp") {
			    echo "Sorry, only JPG, JPEG, PNG, GIF & BMP files are allowed.";
			    $uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
			    echo "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
			} else {
			    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_filed)) {
			    	$target_filed="uploads/".$target_file;   // Updated the value of uploaded name.
			    } else {
			        echo "Sorry, there was an error uploading your file.";
			    }
			  }

			  // File uploaded (or not. I dunno).

			  if($uploadOk==1)
			  {
				  $addquery=mysqli_query($dbcon,"INSERT INTO ".$subscript."libbooks(bookname,author,bookimage,genre,type,noofcopies,isbn,nissues) VALUES('$bookname','$author','$target_filed','$genre','$type','$noofcopies','$isbn','$nissues')");
	          }

			  if($addquery && $uploadOk==1)   // If file uploaded and the query handled.
			  {
			  	echo "Book successfully added.";
			  }
			  else
			  {
			  	echo "Sorry, there was some problem adding the book to the database. Kindly try again.";
			  }
	  		}
	  	}
        // END
	  }
	  ?>

  <button><a href="index.php">Back</a></button> &nbsp&nbsp<button><a href="../index.php">Back to Home</a></button>
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


function checkbook(str)    // Function to check if a book exists using AJAX.
{
    var request=new XMLHttpRequest;

    var string="";

    request.open('GET','checkbook.php?bookname='+str,true);    // True => Asynchnorours.

    request.onload=function()   // When the request loads.
    {
    	string=request.responseText;   // Assigning the response text to the string.

    	if(string!="")
    	    document.getElementById("verifier").innerHTML=("<br><br>"+string.toString());
    	else
    		document.getElementById("verifier").innerHTML=("");
    };

    request.send();   // Sending the request once the user enters the value.

}


</script>

</body>
</html>