<?php
   session_start();
   include 'installinc.php';
   include '../inc/saltgenerator.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Installing Scripts</title>
	<?php include 'installstyles.php'; ?>
	<style>
       a{
       	text-decoration: none;
       	color: #ffffff;
       }
    </style>
</head>
<body>
	<div class="main">
		<?php
		   if($read1=="1"||$read2=="1"||$read3!="0")
		   {
      	       header("refresh:0;url=../index.php");
      	       exit();
           }
           else
           {
		      	
		      	// DATABASE CONNECTION

		      	$host=$_POST['host'];
		      	$dbuser=$_POST['dbuser'];
		      	$dbpassword=$_POST['dbpassword'];
		      	$dbname=$_POST['dbname'];

		      	// ADMINISTRATOR DETAILS

		      	$username=$_POST['username'];
		        $email=$_POST['email'];
		        4name=$_POST['name'];
		      	$pass1=$_POST['pass1'];
		      	$pass2=$_POST['pass2'];
		        $doj=date("Y-m-d");    // Today's date.
		        $isadmin=true;
		        $isbanned=false;   // Obviously.

		        // GENERAL DETAILS OF THE LIBRARY

		        $libname=$_POST['libname'];
		        $libemail=$_POST['libemail'];
		        $subscript=$_POST['subscript'];        // The subscript for the database tables.
		        $maxbooksallowed=$_POST['libmax'];
		        $noofdaysallowed=$_POST['libtime'];
		        $fineperday=$_POST['fineperday'];

		        // ERROR VARIABLES

		        $error=0;
		        $inequal=0;
                
                if($username==""||$pass1==""||$pass2==""||$email==""||$libemail==""||$pass1!=$pass2||$maxbooksallowed==0||$noofdaysallowed==0||$dbuser==""||$host==""||$dbname==""||$subscript==""||$maxbooksallowed<1||$noofdaysallowed<1||$libname=="")   
                // Checking for any inconsistent or unfinished data.(Or rather just empty.)
                {
                	echo "<br><br>Information inconsistent or empty. Kindly go back and check the inputs you entered again.
                	<br>
                	<br>
                	<button><a href='index.php'>Back</a></button>";
                }
                else
                {
			        $dbcon=mysqli_connect($host,$dbuser,$dbpassword,$dbname) or die("<br><br>Could not connect to the database.");

			        if($dbcon)   // If connection was successful.
			        {
			        	// Connected to the source. Now working.

			        	// Rechecking if the passwords match.

			        	if(strlen($pass1)!=strlen($pass2))
			        	{
			        		echo "<br><br>Passwords do not match!
			        		<br>
	                	    <br>
	                	    <button><a href='index.php'>Back</a></button>";
			        		$error++;
			        	}
			        	else
			        	{
			        		for($i=0;$i<strlen($pass1);$i++)
			        		{
			        			if($pass1[$i]!=$pass2[$i])
			        			{
			        				$inequal++;
			        			}
			        		}

			        		if($inequal!=0)
			        		{
			        			echo "<br><br>The passwords do not match!
			        		    <br>
	                	        <br>
	                	        <button><a href='index.php'>Back</a></button>";
	                	    }
			        	}

			        	if($error==0 && $inequal==0)
			        	{
			        		$success=0;  // Successful installation specifying variable.

			        		// Dropping the tables from any previous failed installations.

			        		// Hashing the passwords.
			        		$pass1=crypt($pass1,$salt);
			        		$pass1=md5($pass1);  // Extra layer of security.

				        	$drop1=mysqli_query($dbcon,"DROP TABLE if exists ".$subscript."libissued");

                            $drop2=mysqli_query($dbcon,"DROP TABLE if exists ".$subscript."libwishlist cascade");

					        $drop3=mysqli_query($dbcon,"DROP TABLE if exists ".$subscript."libusers cascade");

					        $drop4=mysqli_query($dbcon,"DROP TABLE if exists ".$subscript."libbooks cascade");

					        $drop5=mysqli_query($dbcon,"DROP TABLE if exists ".$subscript."libgen cascade");

					        // Tables dropped. Now creating them.

					        $state1="CREATE TABLE ".$subscript."libusers(
					        	userid integer(25) auto_increment primary key,
					        	username varchar(50) unique not null,
					        	name text not null,
					        	salt varchar(50) not null,
					        	password varchar(255) not null,
					        	image varchar(255),
					        	email varchar(150) unique not null,
					        	cardid varchar(165) unique not null,
					        	doj date,
					        	isadmin boolean,
					        	isbanned boolean
					        );";

					        $image='uploads/default.png';

					        $query1=mysqli_query($dbcon,$state1);

					        if($query1)
					        {
					        	$success++;
					        	echo "<br><br>Creating Library User Table.";
					        }

					        $state2="CREATE TABLE ".$subscript."libbooks(
					            bookid integer(10) auto_increment primary key,
					            bookname text not null,
					            author text not null,
					            bookimage varchar(255),
					            genre text,
					            type varchar(20),
					            noofcopies integer(9) not null,
					            isbn varchar(14) unique not null,
					            nissues integer(5),
					            check(type IN('Book','Magazine'))
					        );";

					        $query2=mysqli_query($dbcon,$state2);

					        if($query2)
					        {
					        	$success++;
					        	echo "<br><br>Creating Library Books Table.";
					        }

					        $state3="CREATE TABLE ".$subscript."libissued(
					            bookid integer references ".$subscript."libbooks(bookid),
					            userid integer references ".$subscript."libusers(userid),
					            doi date,
					            dor date,
					            fine integer,
					            fine_paid integer
					        )";

					        $query3=mysqli_query($dbcon,$state3);

					        if($query3)
					        {
					        	$success++;
					        	echo "<br><br>Creating Issue Record Table.";
					        }

					        $state4="CREATE TABLE ".$subscript."libgen(
					        	libname text,
					            libemail varchar(250),
					            noofbooks integer(5),
					            noofdays integer(5),
					            fine integer
					        )";

					        $query4=mysqli_query($dbcon,$state4);

					        if($query4)
					        {
					        	$success++;
					        	echo "<br><br>Creating Library Information Table.";
					        }

					        $state5="CREATE TABLE ".$subscript."libwishlist(
					        	userid integer not null,
					            bookid integer not null,
					            bookname text,
					            author text
					        )";

					        $query5=mysqli_query($dbcon,$state5);

					        if($query5)
					        {
					        	$success++;
					        	echo "<br><br>Creating User Wishlist Table.";
					        }

					        // Tables generated, now insertion.

					        $state6="INSERT INTO ".$subscript."libusers(username,name,salt,password,image,email,cardid,doj,isadmin,isbanned) VALUES(
					            '$username','$name','$salt','$pass1','$image','$email','$cardid','$doj','$isadmin','$isbanned'
					        )";   

					        $query6=mysqli_query($dbcon,$state6);

					        if($query6)
					        {
					        	$success++;
					        	echo "<br><Br>Inserting Admin Values.";
					        }

					        $state7="INSERT INTO ".$subscript."libgen VALUES('$libname','$libemail','$maxbooksallowed','$noofdaysallowed','$fineperday')";

					        $query7=mysqli_query($dbcon,$state7);

					        if($query7)
					        {
					        	$success++;
					        	echo "<br><br>Inserting the General Library Information.";
					        }

					        // Checking if the installation was successful.

					        if($success==7)    // If all the steps were successfully executed.
					        {
					          fseek($confirmfile,0);
				              fwrite($confirmfile,"1");
				              fclose($confirmfile);
				              
				              fseek($confirmfile1,0);
				              fwrite($confirmfile1,"1");
				              fclose($confirmfile1); 

				              //2 Confirm Files Made To Avoid Miscommunication!
				              
				              //LATER, CONFIGURATION FILE

				              $configstring="<"."?"."php\n".'$'."host='$host';\n".
                                            '$'."dbuser='$dbuser';\n".
				                          '$'."dbpassword='$dbpassword';\n".
				                          '$'."dbname='$dbname';\n".
				                          '$'."dbcon=mysqli_connect(".'$'.'host'.',$'.'dbuser'.',$'.'dbpassword'.',$'.'dbname'.") or die("."'Could not connect to the database.'".");\n"
				                          ."$"."subscript='$subscript';"."\n?".">";         

					          fseek($config,0);  
                              fwrite($config,$configstring);
                              fclose($config);  

                              //CONFIGURATION FILE MADE

                              echo "<br><br><button><a href=''>Check out your new library!</a></button>";
					        }
					        else
					        {
					        	echo "<Br><br>There was an error that occured during the installtion of the script. <br><br>Kindly Try Again.<br><br><button><a href='index.php'>Back</a></button>";
					        }
			        	}
			        }
			        else
			        {
			        	echo "<br><br>Installation Failed due to connection error. Please recheck the details.
			        	<br>
                	    <br>
                	    <button><a href='index.php'>Back</a></button>";
			        }
			    }
		    }
		?>
	</div>
</body>
</html>