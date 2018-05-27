<?php 
require 'views/layouts/top.php';
?>
			
<section class="content-header">
	<h1>
		Admin <small>Edit information admin</small>
		<small class="pull-right"><i class="fa fa-dashboard"></i> Home > Admin > Edit</small>
	</h1>
</section>

<?php  
require 'views/errors/error.php';
?>

<!-- Content body -->
<section class="content">
	<div class="box">
		<div class="box-header"><span>Edit information admin</span></div>
		<div class="box-body">
			<?php  
			if (empty($admin)) {
				echo 'Not found, <a href="index.php?c=admin&a=index" class="red">return index</a>.';
			} else {
			?>
				<form method="POST" action="index.php?c=admin&a=update&id=<?php echo $admin['id'];?>"" enctype="multipart/form-data">	
					<?php require 'views/admin/form.php'; ?>
				</form>
				<?php 
			}
			?>
			<div class="clear"></div>
		</div>		
	</div>
</section>			
			
<?php
require 'views/layouts/bottom.php';
?>
