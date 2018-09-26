<?php   
      
      //FILES TO OPEN FOR EXECUTION

      $confirmfile=fopen("confirm.txt","r+");
      $confirmfile1=fopen("../confirm1.txt","r+");
      $config=fopen("../inc/config.php","r+");
      
      //CHECK IF THE SCRIPT IS ALREADY INSTALLED

      $read1=fread($confirmfile,filesize("confirm.txt"));
      $read2=fread($confirmfile1,filesize("../confirm1.txt"));
      $read3=fread($config,filesize("../inc/config.php"));
?>