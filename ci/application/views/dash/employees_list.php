<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( !isset($_SESSION['u_name']) || !$_SESSION['u_name'] ) {
	redirect('home','refresh');
}

?>
<!doctype html>
<html lang="en" data-bs-theme="light">
  <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Employees - CodeIgniter EMS</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/theme.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/dashboard.css">
  </head>
  <body>

	<?php $this->load->view('dash/inc/sidebar'); ?>
	<?php $this->load->view('dash/inc/topnav'); ?>

	<main class="main-content">
		<div class="card">
			<div class="card-header d-flex align-items-center">
				<h5 class="mb-0">Employees List</h5>
				<a href="<?php echo site_url(); ?>employees/add_employee" class="btn btn-primary ms-auto">
					<i class="fas fa-plus me-1"></i> Add New Employee
				</a>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered align-middle mb-0">
						<thead>
							<tr>
								<th class="text-center">ID</th>
								<th>Name</th>
								<th>Job</th>
								<th>Department</th>
								<th class="text-center">Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$employees_list = $this->db->get('employees');
							foreach ($employees_list->result() as $employee) { ?>
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
										<a href="<?php echo site_url(); ?>employees/single_employee/<?php echo $employee->e_id; ?>" class="btn btn-sm btn-info" title="View Details">Details</a>
										<a href="<?php echo site_url(); ?>employees/update_employee/<?php echo $employee->e_id; ?>" class="btn btn-sm btn-warning">Edit</a>
										<a href="<?php echo site_url(); ?>employees/delete_employee/<?php echo $employee->e_id; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this employee?')">Delete</a>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</main>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/dashboard.js"></script>
  </body>
</html>