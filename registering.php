<?php
session_start();
include 'inc/config.php';
include 'head.php';   // Checking if the script is instlaled or not.
include 'inc/saltgenerator.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Registering...</title>
	<?php include 'inc/style.php'; ?>
</head>
<body style="background: linear-gradient(45deg, #ffffff 30%,#f2f2f2 30%); height: 100vh;">
<?php include 'header.php'; ?>
<br/><br/><br/>
<div align="center" style="padding: 70px;">
<?php
   if($_SESSION['userid']!=""||$_SESSION['liblogin']==true||$_SESSION['libisadmin']==true)
   {    
     // If the user is already logged in.
   	 header("refresh:0;url=index.php");
   	 exit();
   }
   else
   {
   	  $username=$_POST['username'];
   	  $password=$_POST['password'];
   	  $name=$_POST['name'];
   	  $email=$_POST['email'];
   	  $doj=date("Y-m-d");
   	  $isadmin=0;
   	  $isbanned=0;
   	  $image=$_FILES['image'];
   	  $cardid=$cardid;

   	  if($username!="" && $password!="" && $email!="" && strlen($password)>=8)
   	  {
   	  	  $checkquery=mysqli_query($dbcon,"SELECT * FROM ".$subscript."libusers WHERE username='$username' OR email='$email'");

	   	  if(mysqli_num_rows($checkquery)>0)    // If user with the email or username already exists.
	   	  {
	   	  	echo "<br><br>&nbsp&nbspUser already exists.
	   	  	<br><br>
	  	    <button><a href='regiter.php'>Back</a></button><br><br><button><a href='index.php'>Home</a></button>";
	   	  }
	   	  else
	   	  {
	   	  	$password=crypt($password,$salt);
   	  	    $password=md5($password);   // Hashed the passwords.

   	  	    // Now file uploading.

   	  	    $target_dir = "uploads/";

			$target_file = basename($_FILES["image"]["name"]);

			$target_filed = "uploads/".$target_file;

			$uploadOk = 1;

			$imageFileType = strtolower(pathinfo($target_filed,PATHINFO_EXTENSION));
			// Check if image file is a actual image or fake image
			if(isset($_POST["submit"])) {
			    $check = getimagesize($_FILES["image"]["tmp_name"]);
			    if($check !== false) {
			        echo "File is an image - " . $check["mime"] . ".";
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
			    $target_filed= "uploads/".$target_file;
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
			    } else {
			        echo "Sorry, there was an error uploading your file.";
			    }
			  }

			  if($uploadOk==1)
			  {
				  $registerquery=mysqli_query($dbcon,"INSERT INTO ".$subscript."libusers(username,salt,password,image,email,cardid,doj,isadmin,isbanned) VALUES('$username','$name','$salt','$password','$target_filed','$email','$cardid','$doj','$isadmin','$isbanned')");
			  }

			  if($registerquery && $uploadOk==1)
			  {
			  	echo "<br><Br>Congrats, you are registered.<br><br>
			  	Your card no is : <b>'$cardid'.</b>
			  	<br><br><button><a href='index.php'>Home</a></button>";
			  }
			  else
			  {
			  	echo "<br><Br>Sorry, there was an error while registering you. Kindly try again.<br><br><button><a href='register.php'>Back</a></button><br><br><button><a href='index.php'>Home</a></button>";
			  }
	   	  }
	  }
	  else
	  {
	  	echo "<br><br>Invalid input.<br><br>
	  	<button><a href='regiter.php'>Back</a></button><br><br><button><a href='index.php'>Home</a></button>";
	  }

   }
?>
</div>
</body>
</html>