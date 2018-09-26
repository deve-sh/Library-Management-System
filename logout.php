<?php
  session_start();
  $_SESSION['liblogin']=false;
  $_SESSION['userid']="";
  $_SESSION['libisadmin']=false;
  session_unset();
  header("refresh:0;url=index.php");
  exit();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Logging Out.</title>
</head>
<body>

</body>
</html>