<?php 
if ($this->hasFlash('errors')) {
	?>
	<div class="alert alert-danger">
		<ul>
		<?php
		$errors = $this->getFlash('errors');
		foreach ($errors as $error) {
			echo '<li>'.$error.'</li>';
		}
		?>
		</ul>
	</div>
	<?php
}
?>