<?php 
session_start();
$_SESSION['isindex']=false;
include 'installinc.php';
include '../inc/saltgenerator.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Install Script</title>
  <?php include 'installstyles.php';?>
</head>
<body>
<main align='center'>
	<?php 
      if($read1=="1"||$read2=="1"||$read3!="0"){
      	echo "<br>The script is already installed!";
        $_SESSION['referrer']=$_SERVER['HTTP_REFERRER'];
        header("refresh:1;url=../index.php");
        exit();
      }  
      else{      

      //INSTALLATION FORM

	?>
    <form action="install.php" method="post" id='login'>
    	<h1>Library Script Installation</h1>

        <h3>Database Details</h3>
      
        <span>Only <b>MySQL Improved</b> databases are supported.</span><br><br>
        <input type="text" name="host" maxlength="150" required placeholder="Enter your host!"> <br><br>
        <input type="text" name="dbuser" maxlength="150" required placeholder="Username"><br><br>
        <input type="password" name="dbpassword" maxlength="150" placeholder="Password"><br><br>
        <input type="text" name="dbname" maxlength="150" required placeholder="Database Name"><br><br>
        <input type="text" name="subscript" required placeholder="Enter your Table Subscript" value="lib_"> 
        <br/><br/>
        <h3>Administrator Details</h3>
        <br/>
        <input type="text" name="username" maxlength="150" placeholder="Admin Username" required/><br><br>
        <input type="text" name="name" maxlength="150" placeholder="Admin Name" required/><br/><br/>
        <input type="password" name="pass1" maxlength="150" placeholder="Admin Password" required="required" id='pass1'/><br><br>
        <input type="password" name="pass2" maxlength="150" onkeyup='check()' onkeydown='check()' id='pass2' placeholder="Confirm Password" required="required"><br><br>
        <input type="email" name="email" placeholder="Email Address" maxlength="150" required="required"/><br><br>
        
        <h3>Libarary Details</h3>
        Library Name : <input type="text" name="libname" placeholder="Enter Library Name" required="required">
        <br/><br/>
        Library Email Address : <input type="email" name="libemail" placeholder="Enter Library Email Address" required="required"/><br/><br/>
        No of Books allowed per member : <input type="number" min="1" name="libmax" placeholder="Number of Books Allowed" required="required"/><br/><br/>
        No of Days Allowed per book : <input type="number" min="1" name="libtime" placeholder="Number of Days per book Allowed" required="required"/><br/><br/>
        <button type="submit" id='install'>INSTALL</button>
    </form>
	<?php 
         }     //END OF INSTALLATION FORM

    ?>
</main>
<script type="text/javascript" src='registerscripts.js'></script>
</body>
</html>
