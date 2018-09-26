<div id="mySidenav" class="sidenav">
  <br/>
  <span class="closebtn" onclick="closeNav()">&times;</span>
  <?php
     echo "<a href='index.php'><i class='fas fa-home'></i> &nbsp&nbsp&nbspHome</a>";
     if($_SESSION['liblogin']!=true)
     {
     	echo "<a href='login.php'><i class='fas fa-user'></i> &nbsp&nbsp&nbspLogin</a>";
     	echo "<a href='register.php'><i class='fas fa-user-plus'></i> &nbsp&nbsp&nbspRegister</a>";
     }
     else
     {
     	if($_SESSION['libisadmin']==true)
     	{
     		echo "<a href='dashboard/'><i class='fas fa-user-secret'></i> &nbsp&nbsp&nbspAdmin CP</a>";
     	}
     	echo "<a href='usercp.php'><i class='fas fa-user-cog'></i> &nbsp&nbsp&nbspUser CP</a>";
     	echo "<a href='wishlist.php'><i class='fas fa-heart'></i> &nbsp&nbsp Wishlist</a>";
      echo "<a href='logout.php'><i class='fas fa-user-slash'></i> &nbsp&nbsp Logout</a>";
     }
  ?>
</div>

<div id='topmenu' style="font-family: Roboto,sans-serif;">
	<div class="topleft">
		<a href='javascript:void(0)' onclick="openmenu()">
			<i class="fas fa-bars" class='openmenu'></i>
		</a>
		&nbsp&nbsp
		<?php echo "<i class='fas fa-book'></i>&nbsp&nbsp".$libname; ?>
	</div>
	<div class='topright'>
		<a href="search.php"><i class="fas fa-search"></i></a>
		&nbsp
	</div>
</div>
<script type="text/javascript" src='scripts.js'></script>
