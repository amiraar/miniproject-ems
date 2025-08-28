<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( !$_SESSION['u_name'] ) {
	# code...
	redirect('home','refresh');
}

$id = $this->uri->segment(3);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EMS Project</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
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
			<div class="action-buttons">
				<a href="<?php echo site_url(); ?>employees" class="btn btn-default" title="Back">
				<span class="hidden-xs">Back</span>
				</a>
			</div>
			</div>
			
			<div class="col-lg-9 col-md-9">
				<table class="table table-bordered">
					<?php  

					$employee_details = $this->db->get_where('employees', array('e_id'=>$id));
					if ($employee_details->num_rows() > 0) {
						foreach ($employee_details->result() as $employee) 
						{ ?>
					
						<tr>
							<th>Date</th>
							<td><?php echo $employee->e_date; ?></td>
						</tr>
						<tr>
							<th>Name</th>
							<td><?php echo $employee->e_name; ?></td>
						</tr>
						<tr>
							<th>Email</th>
							<td><?php echo $employee->e_email; ?></td>
						</tr>
						<tr>
							<th>Phone</th>
							<td><?php echo $employee->e_phone; ?></td>
						</tr>
						<tr>
							<th>Job</th>
							<td><?php echo $employee->e_job; ?></td>
						</tr>
						<tr>
							<th>Department</th>
							<td>
								<?php
									if (isset($employee->e_department) && !empty($employee->e_department)) {
										$department = $this->db->get_where('department', array('d_id' => $employee->e_department))->row();
										if ($department) {
											echo $department->d_name;
										} else {
											echo "Department not found";
										}
									} else {
										echo "No Department";
									}
								?>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<a href="<?php echo site_url(); ?>employees/update_employee/<?php echo $employee->e_id; ?>" class="btn btn-warning btn-sm">Edit</a>
								<a href="<?php echo site_url(); ?>employees/delete_employee/<?php echo $employee->e_id; ?>" class="btn btn-danger btn-sm">Delete</a>
							</td>
						</tr>

						<?php }

					} else {
						echo '<div class="alert alert-danger">Employee not found!</div>';
					}

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