<?php
session_start();
include 'inc/config.php';
include 'head.php';
include 'loggedin.php';
?>
<html>
<head>
<title>Change Profile Photo</title>
<?php include 'inc/style.php'; ?>
</head>
<body onload="set()" onresize="set()">
<?php include("header.php"); ?>
<div class="main" align="center">
<?php
if($_SESSION['liblogin']==false || $_SESSION['userid']==""){
    header("refresh:0;url=login.php");
    exit();
}
else{
    $sql="SELECT * FROM ".$subscript."libusers WHERE userid='".$user['userid']."'";
    $result=mysqli_query($dbcon,$sql);
    while($row=mysqli_fetch_assoc($result)){
    echo "<br/><br/>Current profile photo : <br><BR>";
    echo "<img src='".$row['image']."' width='100px' height='100px'><br><br>";
    echo "<br><br>";
    }
    ?>
    <form action="" method="post" enctype="multipart/form-data">
    <label>Upload Photo (Recommended : 100px X 100px or Square) : </label><br><br>
    <input type="file" name="image" required/><br><br>
    <button type='submit'>SUBMIT</button>
    </form>
    <?php
    if(basename($_FILES['image']['name'])==""){
    	echo "";
        $uploadOk=0;
    }
    else
    {
        $target_dir = "uploads/";
        $target_file = basename($_FILES["image"]["name"]);
        $target_filed = "uploads/".$target_file;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_filed,PATHINFO_EXTENSION));
        // Check if image file is an actual image or fake image
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
        if ($_FILES["image"]["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
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
        $sql1="UPDATE ".$subscript."libusers set image='$target_filed' WHERE userid='".$user['userid']."'";
        $result1=mysqli_query($dbcon,$sql1);
        if($result1){
           echo "Record Updated!";
           header("refresh:1;url=usercp.php");
           exit();
        }
        else{
           echo "Record Could not be updated! Please Try Again!";
        }
    }
}
?>	
</div>
</body>
</html>