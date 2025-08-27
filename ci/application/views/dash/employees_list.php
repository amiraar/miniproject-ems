<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( !$_SESSION['u_name'] ) {
	# code...
	redirect('home','refresh');
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EMS Project</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/button-spacing.css">
	<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    
    <!-- dash nav -->
    <?php $this->load->view('dash/inc/nav'); ?>
    <!-- dash nav -->

	<!-- dash data -->
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-md-3">
				<!-- sidebar -->
				<?php $this->load->view('dash/inc/sidebar'); ?>
				<!-- sidebar -->
			</div>
			<div class="col-lg-9 col-md-9">
				<table class="table table-bordered">
					<tr>
						<th class="text-center">ID</th>
						<th class="text-center">Name</th>
						<th class="text-center">Job</th>
						<th class="text-center">Department</th>
						<th class="text-center">Actions</th>
					</tr>
					<?php  

					$employees_list = $this->db->get('employees');
					foreach ($employees_list->result() as $employee) 
					{ ?>
					
					<tr>
						<td class="text-center"><?php echo $employee->e_id; ?></td>
						<td><?php echo $employee->e_name; ?></td>
						<td><?php echo $employee->e_job; ?></td>
						<td>
							<?php
								if (isset($employee->e_department) && !empty($employee->e_department)) {
									$department = $this->db->get_where('department', array('d_id' => $employee->e_department))->row();
									echo $department ? $department->d_name : 'No Department';
								} else {
									echo 'No Department';
								}
							?>
						</td>
						<td class="text-center">
							<div class="action-buttons">
								<a href="<?php echo site_url(); ?>employees/single_employee/<?php echo $employee->e_id; ?>" class="btn btn-info btn-xs btn-separated" title="View Details">
									<span class="hidden-xs">Details</span>
								</a>
								<a href="<?php echo site_url(); ?>employees/update_employee/<?php echo $employee->e_id; ?>" class="btn btn-warning btn-xs btn-separated" title="Edit">
									<span class="hidden-xs">Edit</span>
								</a>
								<a href="<?php echo site_url(); ?>employees/delete_employee/<?php echo $employee->e_id; ?>" class="btn btn-danger btn-xs btn-separated" title="Delete" onclick="return confirm('Are you sure you want to delete this employee?')">
									<span class="hidden-xs">Delete</span>
								</a>
							</div>
						</td>
					</tr>

					<?php }

					?>
				</table>
			</div>
		</div>
	</div>
	<!-- dash data -->


	<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
  </body>
</html>