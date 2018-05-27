<?php 
require 'views/layouts/top.php';	
?>
			
<section class="content-header">
	<h1>
		Admin <small>List of Admin</small>
		<small class="pull-right"><i class="fa fa-dashboard"></i> Home > Admin > Index</small>
	</h1>
</section>

<?php 
// Show notification
require 'views/others/notify.php';

// Show errors
require 'views/errors/error.php';

// Session URL (info search, sort, pagination)
if (isset($_GET['name'])) 	 $_SESSION['urlAdmin']['name']    = trim($_GET['name']);
if (isset($_GET['email'])) 	 $_SESSION['urlAdmin']['email']   = trim($_GET['email']);
if (isset($_GET['row'])) 	 $_SESSION['urlAdmin']['row'] 	  = trim($_GET['row']);
if (isset($_GET['arrange'])) $_SESSION['urlAdmin']['arrange'] = trim($_GET['arrange']);
if (isset($_GET['limit'])) 	 $_SESSION['urlAdmin']['limit']   = trim($_GET['limit']);
if (isset($_GET['page'])) 	 $_SESSION['urlAdmin']['page']    = trim($_GET['page']);
?>

<!-- Content body -->
<section class="content">
	<div class="box">
		<div class="box-header"><span>Search admin</span></div>
		<div class="box-body">
			<form method="GET">
				<input type="hidden" name="c" value="admin">
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
				if (isset($_GET['limit'])) 
				{
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
		<div class="box-header"><span>List of Admin</span></div>
		<div class="box-body">
			<button type="button" class="btn-a btn-success" style="margin-bottom: 15px;"><a href="index.php?c=admin&a=index">Reload</a></button>
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
			<div class="table-responsive">
				<table id="myTable" class="table">
					<thead>
						<th width="5%">No.</th>
						<th width="20%">Name <span onclick="sortDB('name')" >&uarr;&darr;</span></th>
						<th width="35%">Email <span onclick="sortDB('email')" >&uarr;&darr;</span></th>
						<th width="20%">Role <span onclick="sortDB('role_type')">&uarr;&darr;</span></th>
						<th width="5%">Show</th>
						<th width="5%">Edit</th>
						<th width="5%">Delete</th>
					</thead>
					
					<tbody>
						<?php 
						if (empty($admin)) {
							?>
							<tr>
								<td colspan="7" class="text-center red"><i class="fa fa-exclamation-triangle"></i> Not data</td>
							</tr>
							<?php
						}
						$no = 1; 
						foreach ($admin as $item) {
						?>
							<tr>
								<td class="text-center"><?php echo $no;?></td>
								<td class="over-flow padding-left-5"><a href="index.php?c=admin&a=show&id=<?php echo $item['id'];?>"><?php echo $item['name'];?></a></td>
								<td class="padding-left-5"><?php echo $item['email'];?></td>
								<td class="padding-left-5"><?php echo ($item['role_type'] == 1) ? "Super admin" : "Admin";?></td>
								<td class="text-center"><button type="button" class="btn-a btn-primary"><a href="index.php?c=admin&a=show&id=<?php echo $item['id'];?>"><i class="fa fa-th-list"></i></a></button></td>
								<td class="text-center"><button type="button" class="btn-a btn-success"><a href="?c=admin&a=edit&id=<?php echo $item['id'];?>"><i class="fa fa-pencil"></i></a></button></td>
								<td class="text-center">
									<?php if ($item['role_type'] == 2) { ?>
									<button type="button" class="btn-a btn-danger"><a href="?c=admin&a=destroy&id=<?php echo $item['id'];?>" onclick="return confirm('Are you sure to delete this admin?');"><i class="fa fa-trash"></i></a></button>
									<?php } ?>
								</td>
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
			<?php require 'views/others/pagination.php'; ?>
			<div class="clear"></div>
		</div>
	</div>
</section>	

<?php
require 'views/layouts/bottom.php';
?>
