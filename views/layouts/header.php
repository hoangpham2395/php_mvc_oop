			<!-- Logo -->
			<span class="logo">Training php</span>
			<!-- Logout -->
			<div class="dropdown pull-right">
		  		<button class="dropbtn">
		  			<?php echo getNameAdmin(); ?>
		  			<i class="fa fa-angle-down"></i>
		  		</button>
		  		<div class="dropdown-content">
    				<a href="index.php?c=admin&a=show&id=<?php echo $_SESSION['admin_user']['id'];?>"><i class="fa fa-user"></i> My profile</a>
    				<a href="index.php?c=login&a=logout"><i class="fa fa-sign-out"></i> Sign out</a>
  				</div>
			</div>

