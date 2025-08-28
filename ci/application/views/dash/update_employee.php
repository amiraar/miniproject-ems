<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( !$_SESSION['u_name'] ) {
	# code...
	redirect('home','refresh');
}
?>

<!doctype html>
<html lang="en" data-bs-theme="light">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Employee - CodeIgniter EMS</title>
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
        <div class="card-header">Update Employee</div>
        <div class="card-body">

              <?php  

              $employee_details = $this->db->get_where('employees', array('e_id'=>$e_id));
              if ($employee_details->num_rows() > 0) {
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
                
              }else{
                echo '<div class="alert alert-danger">Employee not found!</div>';
              }

                ?>
            </div>
        </div>
      </div>
    </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/dashboard.js"></script>
    <script>
    function setDepartment() {
        var jobSelect = document.getElementById('jobSelect');
        var selectedOption = jobSelect.options[jobSelect.selectedIndex];
        var departmentId = selectedOption.getAttribute('data-department-id');
        var departmentName = selectedOption.getAttribute('data-department-name');
        document.getElementById('departmentId').value = departmentId || '';
        document.getElementById('departmentDisplay').value = departmentName || '';
    }
    document.addEventListener('DOMContentLoaded', function() { setDepartment(); });
    </script>
  </body>
</html>