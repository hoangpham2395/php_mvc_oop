<section class="sidebar">
	<!-- User -->
	<div class="user-panel">
		<!-- Avatar -->
		<div class="pull-left image">
			<a href="index.php?c=admin&a=show&id=<?php echo $_SESSION['admin_user']['id'];?>">
				<img src="<?php echo getImageAdmin();?>" class="img-cirle" alt="Avatar">
			</a>
		</div>

		<!-- Information -->
		<div class="pull-left info">
			<p><a href="index.php?c=admin&a=show&id=<?php echo $_SESSION['admin_user']['id'];?>"><?php echo getNameAdmin(); ?></a></p>
			
			<?php 
			$connected = @fsockopen("www.example.com", 80); 
		    if ($connected){
		        echo '<span class="green">&#9679;</span> Online';
		        fclose($connected);
		    } else {
		    	echo '<span class="red">&#9679;</span> Offline';
		    }
			?>
		</div>

		<div class="clear"></div>
	</div>

	<!-- Menu -->
	<ul class="sidebar-menu">
		<li id="treeview" onclick="clickMenu()">
			<span class="treeview-title"><i class="fa fa-user"></i> Admin</span>
			<span class="pull-right" style="margin-right: 15px;"><i id="sidebar-down" class="fa fa-angle-down"></i></span>
		</li>
		<ul id="treeview-menu">
			<li><a href="index.php?c=admin&a=index"><i class="fa fa-th-list"></i> List of admins</a></li>
			<li><a href="index.php?c=admin&a=create"><i class="fa fa-plus-circle"></i> Add new admin</a></li>
		</ul>
		<li>
			<a href="?c=users&a=index"><i class="fa fa-users"></i> Users</a>
		</li>
	</ul>
</section>