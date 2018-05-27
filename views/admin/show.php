<?php 
require 'views/layouts/top.php';
?>
			
<section class="content-header">
	<h1>
		Admin <small>Infomation</small>
		<small class="pull-right"><i class="fa fa-dashboard"></i> Home > Admin > Show</small>
	</h1>
</section>

<!-- Content body -->
<section class="content">
	<div class="box">
		<div class="box-header"><span>Infomation</span></div>
		<div class="box-body">
			<?php  
			if (empty($admin)) {
				echo 'Not found, <a href="index.php?c=admin&a=index" class="red">return index</a>.';
			} else {
			?>
				<div class="form-group width30">
					<img src="<?php echo $urlImage;?>" class="img-show" alt="Avatar">
				</div>
				<div class="form-group width50">
					<div class="margin-top-15"></div>
					<span>Name: <b><?php echo $admin['name'];?></b></span>
					<div class="margin-top-15"></div>
					<span>Email: <b><?php echo $admin['email'];?></b></span>
					<div class="margin-top-15"></div>
					<span>Role: <b><?php echo ($admin['role_type'] == 1) ? "Super admin" : "Admin";?></b></span><br>
					<div class="margin-top-15"></div>
					<button type="button" class="btn-a btn-primary"><a href="?c=admin&a=edit&id=<?php echo $admin['id'];?>"><i class="fa fa-pencil"></i></a></button> 
					<?php if ($admin['role_type'] == 2) { ?>
						<button type="button" class="btn-a btn-danger"><a href="?c=admin&a=destroy&id=<?php echo $admin['id'];?>" onclick="return confirm('Are you sure to delete this admin?');"><i class="fa fa-trash"></i></a></button>
					<?php } ?>
					<button type="button" class="btn-a btn-success"><a href="?c=admin&a=index"><i class="fa fa-chevron-circle-left"></i></a></button>
				</div>
				<?php 
			}
			?>
		</div>	
		<div class="clear"></div>	
	</div>
</section>			
			
<?php
require 'views/layouts/bottom.php';
?>