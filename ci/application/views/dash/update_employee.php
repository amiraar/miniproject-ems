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
          <div class="panel panel-default">
            <div class="panel-heading">Update Employee</div>
            <div class="panel-body">

              <?php  

              $employee_details = $this->db->get_where('employees', array('e_id'=>$e_id));
              foreach ($employee_details->result() as $employee) 
              { ?>

              <?php echo form_open('employees/update_employee_process/'. $employee->e_id, 'class="form-horizontal"'); ?>

                <div class="form-group">
                  <label class="col-sm-2 control-label">Name</label>
                  <div class="col-sm-10">
                    <input type="text" name="e_name" class="form-control input-sm" placeholder="Name" value="<?php echo $employee->e_name; ?>" required>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">Email ID</label>
                  <div class="col-sm-10">
                    <input type="text" name="e_email" class="form-control input-sm" placeholder="Email" value="<?php echo $employee->e_email; ?>" required>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">Phone</label>
                  <div class="col-sm-10">
                    <input type="text" name="e_phone" class="form-control input-sm" placeholder="Phone" value="<?php echo $employee->e_phone; ?>" required>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">Select Job</label>
                  <div class="col-sm-10">
                    <select name="e_job" id="jobSelect" class="form-control input-sm" required onchange="setDepartment()">
                      <option value="">-- Select Job --</option>
                      <?php if (isset($jobs) && !empty($jobs)): ?>
                        <?php foreach ($jobs as $job): ?>
                          <option value="<?php echo $job->j_name; ?>" 
                                  <?php echo ($job->j_name == $employee->e_job) ? 'selected' : ''; ?>
                                  data-department-id="<?php echo $job->d_id; ?>" 
                                  data-department-name="<?php echo isset($job->d_name) ? $job->d_name : ''; ?>">
                            <?php echo $job->j_name; ?> (<?php echo isset($job->d_name) ? $job->d_name : 'No Department'; ?>)
                          </option>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <option value="">No jobs available. Please add jobs first.</option>
                      <?php endif; ?>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">Department</label>
                  <div class="col-sm-10">
                    <input type="text" id="departmentDisplay" class="form-control input-sm" placeholder="Department will be auto-filled" readonly>
                    <input type="hidden" name="e_department" id="departmentId" value="<?php echo isset($employee->e_department) ? $employee->e_department : ''; ?>">
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" name="update_employee" class="btn btn-sm btn-success" value="Update Employee">
                  </div>
                </div>
              </form>

              <?php }

              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- dash data -->

    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    
    <script>
    function setDepartment() {
        var jobSelect = document.getElementById('jobSelect');
        var selectedOption = jobSelect.options[jobSelect.selectedIndex];
        var departmentId = selectedOption.getAttribute('data-department-id');
        var departmentName = selectedOption.getAttribute('data-department-name');
        
        document.getElementById('departmentId').value = departmentId || '';
        document.getElementById('departmentDisplay').value = departmentName || '';
    }
    
    // Set department on page load based on current job selection
    document.addEventListener('DOMContentLoaded', function() {
        setDepartment();
    });
    </script>
  </body>
</html>