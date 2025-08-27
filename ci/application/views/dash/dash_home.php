<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( !$_SESSION['u_name'] ) {
	# code...
	redirect('home','refresh');
}

?><!doctype html>
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
			<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 sidebar-container">
				<!-- sidebar -->
				<?php $this->load->view('dash/inc/sidebar'); ?>
				<!-- sidebar -->
			</div>
			<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 main-content">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Dashboard</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-xs-12 col-sm-6 col-md-4">
								<div class="panel panel-primary">
									<div class="panel-heading">
										<h4 class="panel-title">Total Employees</h4>
									</div>
									<div class="panel-body text-center">
										<h2>
											<?php 
											$employees_count = $this->db->count_all('employees');
											echo $employees_count;
											?>
										</h2>
									</div>
								</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-4">
								<div class="panel panel-success">
									<div class="panel-heading">
										<h4 class="panel-title">Total Jobs</h4>
									</div>
									<div class="panel-body text-center">
										<h2>
											<?php 
											$jobs_count = $this->db->count_all('jobs');
											echo $jobs_count;
											?>
										</h2>
									</div>
								</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-4">
								<div class="panel panel-info">
									<div class="panel-heading">
										<h4 class="panel-title">Total Departments</h4>
									</div>
									<div class="panel-body text-center">
										<h2>
											<?php 
											$departments_count = $this->db->count_all('department');
											echo $departments_count;
											?>
										</h2>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- dash data -->


	<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
  </body>
</html>