<?php 
require 'views/layouts/top.php';
?>
			
<section class="content-header">
	<h1>
		Admin <small>Add new admin</small> 
		<small class="pull-right"><i class="fa fa-dashboard"></i> Home > Admin > Add</small> 
	</h1>
</section>

<?php  
// Show errors
require 'views/errors/error.php';
?>

<!-- Content body -->
<section class="content">
	<div class="box">
		<div class="box-header"><span>Add new admin</span></div>
		<div class="box-body">
			<form method="POST" action="index.php?c=admin&a=add" enctype="multipart/form-data">	
				<?php require 'views/admin/form.php';?>			
			</form>
			<div class="clear"></div>
		</div>		
	</div>
</section>			
			
<?php
require 'views/layouts/bottom.php';
?>
