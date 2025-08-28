<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( !$_SESSION['u_name'] ) {
	# code...
	redirect('home','refresh');
}

$id = $this->uri->segment(3);
?>
<!doctype html>
<html lang="en" data-bs-theme="light">
  <head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Employee Details - CodeIgniter EMS</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/theme.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/dashboard.css">
  </head>
  <body>
		<?php $this->load->view('dash/inc/sidebar'); ?>
		<?php $this->load->view('dash/inc/topnav'); ?>

		<main class="main-content">
			<div class="mb-3">
				<a href="<?php echo site_url(); ?>employees" class="btn btn-outline-secondary btn-sm">Back</a>
			</div>
			<div class="card">
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered mb-0">
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
		</main>

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/dashboard.js"></script>
  </body>
</html>