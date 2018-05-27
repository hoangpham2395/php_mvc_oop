<?php 
if ($this->hasFlash('notification')) {
	?>
	<div class="alert alert-success">
		<ul>
			<li><?php echo $this->getFlash('notification');?></li>
		</ul>
	</div>
	<?php
}
?>