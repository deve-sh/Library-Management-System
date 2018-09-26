<?php
session_start();
include 'inc/config.php';
include 'head.php';
include 'loggedin.php';
include 'inc/saltgenerator.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Change Password</title>
	<?php include 'inc/style.php'; ?>
</head>
<body onresize="set()" onload="set()">
<?php  include 'header.php'; ?>
    <div class="main" align="center">
    	<br/><br/>
    <?php
       if($_SESSION['liblogin']==true && $_SESSION['userid']!="")
       {
    ?>
    	<form action="" align='center' method="post" class="loginform">
    		<h3>Reset Password</h3>
    		<br/>
    		<input type="password" name="oldpass" placeholder="Old Password">
    		<br/><br/>
    		<input type="password" name="newpass" placeholder="New Password">
    		<br/><br/>
    		<button type="submit">Change</button>
    	</form>
    <?php
            $oldpass=$_POST['oldpass'];
            $newpass=$_POST['newpass'];

            $userid=$user['userid'];

            if($oldpass!="" && $newpass!="")
            {
                $oldsalt=$user['salt'];

            // Checking if the old password is the correct one.

            $oldpass=crypt($oldpass,$oldsalt);
            $oldpass=md5($oldpass);

            if(strcmp($oldpass,$user['password'])==0)
            {
                $newpass=crypt($newpass,$salt);
                $newpass=md5($newpass);

                $updater=mysqli_query($dbcon,"UPDATE ".$subscript."libusers SET password='$newpass',salt='$salt' WHERE userid='".$user['userid']."'");

                if($updater)
                {
                    echo "<br/><br/>Password updated successfully.<br><br>You will be redirected successfully to the home page.";
                    header("refresh:2;url=index.php");
                    exit();
                }
                else
                {
                    echo "<br/><br/>Password Could Not be changed. Kindly Try Again.";
                }
            }
            else
            {
                echo "<br/><br/>Old Password does not match the original one. Kindly Try Again.";
            }
            }
            
       }
       else
       {
       	echo "Not logged in!";
       	header("refresh:1;url=login.php");
       	exit();
       }
    ?>
    </div>
	<script type="text/javascript" src="scripts.js"></script>
</body>
</html>