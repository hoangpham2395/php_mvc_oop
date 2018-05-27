<?php 

if (isset($_SESSION['admin_user'])) {
	require 'views/layouts/top.php';
?>
			
<section class="content-header">
	<h1>Error <small>Admin role</small></h1>
</section>

<!-- Content body -->
<section class="content">
	<div class="box">
		<div class="box-header"><span>Notification</span></div>
		<div class="box-body">
			<span style="margin-left: 15px;">You do not have permission to access this page.
			Return to <a href="index.php?c=users&a=index" style="color: red;">users management</a>.</span>
			<div class="clear"></div>
		</div>		
	</div>
</section>			

<?php
	require 'views/layouts/bottom.php';
} else {
	header("location:index.php?c=login&a=show");
}
?>
