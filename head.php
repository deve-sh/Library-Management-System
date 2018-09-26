<?php   
      
      //FILES TO OPEN FOR EXECUTION

      $confirmfile=fopen("install/confirm.txt","r+");
      $confirmfile1=fopen("confirm1.txt","r+");
      $config=fopen("inc/config.php","r+");
      
      //CHECK IF THE SCRIPT IS ALREADY INSTALLED

      $read1=fread($confirmfile,filesize("install/confirm.txt"));
      $read2=fread($confirmfile1,filesize("confirm1.txt"));
      $read3=fread($config,filesize("inc/config.php"));
      
      if($read1=="0"||$read2=="0"||$read3=="0")
      {
            header("refresh:0;url=install/index.php");    // Redirect the user to the installation if the script has not been installed.
            exit();
      }
      else
      {
            // If script is installed. Let's use the name of the library.
            $libraryname=mysqli_query($dbcon,"SELECT * FROM ".$subscript."libgen");

            $libdetails=mysqli_fetch_assoc($libraryname);

            $libname=$libdetails['libname'];

            if(strpos($libname, "library")!==false || strpos($libname, "Library")!==false)
            {
                  $libname=$libname;
            }
            else
            {
                  $libname=$libname." Library";  // Add Library to the name of the library if the word isn't there in the string.
            }
      }
?>