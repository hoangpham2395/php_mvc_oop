<?php
$oldValues = [];

if (isset($_SESSION['old-admin'])) {
	$oldValues = $this->getFlash('old-admin');
}

if (isset($_SESSION['avatar'])) {
	unset($_SESSION['avatar']);
}
?>

<div class="form-group width50">
	<label for="name">Name: <span class="red"> <i class="fa fa-asterisk"></i> </span></label><br>
	<input type="input" name="name" class="form-control" value="<?php echo (isset($oldValues['name'])) ? $oldValues['name'] : $admin['name']; ?>">
</div>

<div class="form-group width50">
	<label for="email">Email: <span class="red"> <i class="fa fa-asterisk"></i> </span></label><br>
	<input type="email" name="email" class="form-control" value="<?php echo (isset($oldValues['email'])) ? $oldValues['email'] : $admin['email']; ?>">
</div>

<div class="form-group width50">
	<label for="password"><?php echo (isset($admin['id'])) ? 'New password:' : 'Password: <span class="red"><i class="fa fa-asterisk"></i></span>';?></label><br>
	<input type="password" name="<?php echo (isset($admin['id'])) ? 'new_password' : 'password'; ?>" class="form-control">
</div>

<div class="form-group width50">
	<label for="password_confirmation">Password confirmation: <?php echo (isset($admin['id'])) ? '' : '<span class="red"><i class="fa fa-asterisk"></i></span>'; ?> </label><br>
	<input type="password" name="password_confirmation" class="form-control">
</div>

<div class="form-group width50">
	<label for="role_type">Role: <span class="red"> <i class="fa fa-asterisk"></i> </span></label><br>
	<select name="role_type">
		<?php 
		$listRoles = ['' => '---Select role type---'];

		$roleSuperAdmin = getConfig('roleSuperAdmin', ['value' => 1, 'text' => 'Super admin']);
		$listRoles[$roleSuperAdmin['value']] = $roleSuperAdmin['text'];

		$roleAdmin = getConfig('roleAdmin', ['value' => 2, 'text' => 'Admin']);
		$listRoles[$roleAdmin['value']] = $roleAdmin['text'];

		if (isset($oldValues['role_type'])) $admin['role_type'] = $oldValues['role_type'];

		foreach ($listRoles as $key => $role) {
			$selected = ($admin['role_type'] == $key) ? 'selected' : '';
			
			echo '<option value="'.$key.'" '.$selected.' >'.$role.'</option>';
		}
		?>
	</select>
</div>

<div class="form-group width50">
	<label for="avatar">Avatar:</label><br>
	<div class="img-file">
		<button type="button" class="btn btn-danger"><label for="avatar"><i class="fa fa-image"></i></label></button> 
		<input type="file" name="avatar" id="avatar" style="display: none;" onchange="getImage(this.value)"> 
		<span id="nameAvatar">
			<?php
			if (!empty($oldValues['file']['name'])) {
				$admin['avatar'] = $oldValues['file']['name'];
				$this->setFlash('avatar', $oldValues['file']); 
			}
			if (!empty($admin['avatar']) && file_exists('uploads/images/'.$admin['avatar'])) {
				echo $admin['avatar'];
			} else {
				echo 'Choose an avatar...';
			}
			?>
		</span>
	</div>	
</div>

<div class="form-group width100 text-center">
	<button type="submit" name="save" class="btn btn-danger" value="save">Save</button>
	<button type="button" class="btn-a btn-primary"><a href="index.php?c=admin&a=index">Cancel</a></button>
</div>