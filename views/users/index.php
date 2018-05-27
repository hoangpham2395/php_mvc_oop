<?php 
require 'views/layouts/top.php';
?>
			
<section class="content-header">
	<h1>
		Users <small>List of Users</small>
		<small class="pull-right"><i class="fa fa-dashboard"></i> Home > Users > Index</small>
	</h1>
</section>

<?php 
// Show notification
require 'views/others/notify.php';

// Show errors
require 'views/errors/error.php';

// Session URL (info search, sort, pagination)
if (isset($_GET['name'])) 	 $_SESSION['urlUser']['name']    = trim($_GET['name']);
if (isset($_GET['email'])) 	 $_SESSION['urlUser']['email']   = trim($_GET['email']);
if (isset($_GET['row'])) 	 $_SESSION['urlUser']['row'] 	 = trim($_GET['row']);
if (isset($_GET['arrange'])) $_SESSION['urlUser']['arrange'] = trim($_GET['arrange']);
if (isset($_GET['limit'])) 	 $_SESSION['urlUser']['limit']   = trim($_GET['limit']);
if (isset($_GET['page'])) 	 $_SESSION['urlUser']['page']    = trim($_GET['page']);
?>

<!-- Content body -->
<section class="content">
	<div class="box">
		<div class="box-header"><span>Search user</span></div>
		<div class="box-body">
			<form method="GET">
				<input type="hidden" name="c" value="users">
				<input type="hidden" name="a" value="index">
				<div class="form-group width50">
					<label for="name">Name:</label><br>
					<input type="input" name="name" class="form-control" value="<?php echo (isset($_GET['name'])) ? $_GET['name'] : ''; ?>">
				</div>
				<div class="form-group width50">
					<label for="email">Email:</label><br>
					<input type="text" name="email" class="form-control" value="<?php echo (isset($_GET['email'])) ? $_GET['email'] : ''; ?>">
				</div>
				<?php 
				if (isset($_GET['limit'])) {
					?>
					<input type="hidden" name="limit" value="<?php echo $_GET['limit'];?>">	
					<?php
				}
				?>

				<div class="form-group width100 text-center">
					<button type="submit" class="btn btn-danger">Search</button>
					<button type="reset" class="btn btn-primary">Reset</button>
				</div>
			</form>
			<div class="clear"></div>
		</div>		
	</div>

	<div class="box">
		<div class="box-header"><span>List of Users</span></div>
		<div class="box-body">
			<div class="width100">
				<button type="button" class="btn-a btn-success" style="margin-bottom: 15px;"><a href="index.php?c=users&a=index">Reload</a></button>
				<div class="pull-right">
					Number of rows:
					<select id="limit" onchange="limitChanged(this)" style="height: 35px;">
						<?php 
						foreach ($listLimit as $limit) {
							?>
							<option value="<?php echo $limit?>" <?php if (isset($_GET['limit']) && $_GET['limit'] == $limit) echo 'selected';?> ><?php echo $limit?></option>
							<?php
						}
						?>
					</select>
				</div>
			</div>
			<div class="table-responsive">
				<table id="myTable" class="table">
					<thead>
						<th width="5%">No.</th>
						<th width="20%">Name <span onclick="sortDB('name');" value='desc'>&uarr;&darr;</span></th>
						<th width="30%">Email <span onclick="sortDB('email')">&uarr;&darr;</span></th>
						<th width="20%">Facebook ID</th>
						<th width="12%">Status <span onclick="sortDB('status')">&uarr;&darr;</span></th>
						<th width="8%">Edit status</th>
						<th width="5%">Delete</th>
					</thead>
					
					<tbody>
						<?php 
						if (empty($users)) {
							?>
							<tr>
								<td colspan="7" class="text-center red"><i class="fa fa-exclamation-triangle"></i> Not data</td>
							</tr>
							<?php
						}
						$no = 1; 
						$active = getConfig('active', ['value' => 1, 'text' => 'Active']);
						$blocked = getConfig('blocked', ['value' => 2, 'text' => 'Blocked']);
						$listStatus = [$active['value'] => $active['text'], $blocked['value'] => $blocked['text']];
						foreach ($users as $user) {
						?>
							<tr>
								<td class="text-center"><?php echo $no;?></td>
								<td class="padding-left-5"><?php echo $user['name'];?></td>
								<td class="padding-left-5"><?php echo $user['email'];?></td>
								<td class="padding-left-5"><?php echo $user['facebook_id'];?></td>
								<td class="padding-left-5"><?php echo $listStatus[$user['status']]; ?></td>
								<td class="text-center">
									<button type="button" class="btn-a btn-<?php echo ($user['status'] == 2) ? 'warning' : 'primary'; ?>"><a href="?c=users&a=edit&id=<?php echo $user['id'];?>" onclick="return confirm('Are you sure to edit status?');"><i class="fa fa-<?php echo ($user['status'] == 1) ? 'lock' : 'unlock';?>"></i></a></button>
								</td>
								<td class="text-center"><button type="button" class="btn-a btn-danger"><a href="?c=users&a=destroy&id=<?php echo $user['id'];?>" onclick="return confirm('Are you sure to delete this user?');"><i class="fa fa-trash"></i></a></button></td>
							</tr>
							<?php 
							$no ++;
						}
						?>
					</tbody>
				</table>
			</div>
			<span class="pull-left margin-top-15"><?php echo 'Showing '.$count['showing'].' of '.$count['total'].' rows.'; ?></span>
			<!-- Pagination -->
			<?php 
			require 'views/others/pagination.php';
			?>
			<div class="clear"></div>
		</div>
	</div>
</section>			

<?php
require 'views/layouts/bottom.php';
?>
