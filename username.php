<?php
session_start();
include 'inc/config.php';
include 'head.php';
include 'loggedin.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Change Username</title>
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
    		<h3>Change Username</h3>
    		<br/>
    		<input type="text" name="oldpass" placeholder="Old Username">
    		<br/><br/>
    		<input type="text" name="newpass" placeholder="New Username">
    		<br/><br/>
    		<button type="submit">Change</button>
    	</form>
    <?php
            $oldpass=$_POST['oldpass'];
            $newpass=$_POST['newpass'];

            $userid=$user['userid'];

            // Checking if the old username is the correct one.

            if($oldpass!="" && $newpass!="")
            {
                
            if(strcmp($oldpass,$user['username'])==0)
            {  

            // If the usernames match

                $check=mysqli_num_rows(mysqli_query($dbcon,"SELECT * FROM ".$subscript."libusers WHERE username='$newpass'"));

                if($check==0)
                {
                    $updater=mysqli_query($dbcon,"UPDATE ".$subscript."libusers SET username='$newpass' WHERE userid='".$user['userid']."'");

                    if($updater)
                    {
                        echo "<br/><br/>Username updated successfully.<br><br>You will be redirected successfully to the home page. Kindly Login Again.";
                        header("refresh:2;url=logout.php");
                        exit();
                    }
                    else
                    {
                        echo "<br/><br/>Username Could Not be changed. Kindly Try Again.";
                    }

                }
                else
                {
                    echo "<br/><br/>Username has already been taken. Kindly Try Another one.";
                }

            }
            else
            {
                echo "<br/><br/>Old Username does not match the original. Kindly Try Again.";
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