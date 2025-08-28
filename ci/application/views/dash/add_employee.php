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
  <title>Add Employee - CodeIgniter EMS</title>
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
    <div class="card-header">Add Employee</div>
    <div class="card-body">
              <?php echo form_open('employees/add_employee_process', 'class="form-horizontal"'); ?>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Name</label>
                  <div class="col-sm-10">
                    <input type="text" name="e_name" class="form-control input-sm" placeholder="Name" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Email ID</label>
                  <div class="col-sm-10">
                    <input type="text" name="e_email" class="form-control input-sm" placeholder="Email" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Phone</label>
                  <div class="col-sm-10">
                    <input type="text" name="e_phone" class="form-control input-sm" placeholder="Phone" required>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">Select Job</label>
                  <div class="col-sm-10">
                    <select name="e_job" id="jobSelect" class="form-control input-sm" required onchange="setDepartment()">
                      <option value="">-- Select Job --</option>
                      <?php if (isset($jobs) && !empty($jobs)): ?>
                        <?php foreach ($jobs as $job): ?>
                          <option value="<?php echo $job->j_name; ?>" data-department-id="<?php echo $job->d_id; ?>" data-department-name="<?php echo isset($job->d_name) ? $job->d_name : ''; ?>">
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
                    <input type="hidden" name="e_department" id="departmentId" value="">
                  </div>
                </div>
                
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" name="add_employee" class="btn btn-sm btn-success" value="Add Employee">
                  </div>
                </div>
              </form>
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
  // Minimal shared behavior: theme + clock + sidebar
  (function(){
    const html = document.documentElement;
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.querySelector('.sidebar');
    const savedTheme = localStorage.getItem('theme') || 'light';
    html.setAttribute('data-bs-theme', savedTheme);
    function updateClock(){
      const now=new Date();
      const el=document.getElementById('digitalClock');
      if(el) el.textContent=now.toLocaleTimeString();
    }
    updateClock(); setInterval(updateClock,1000);
    if(sidebarToggle && sidebar){
      sidebarToggle.addEventListener('click',function(e){e.stopPropagation();sidebar.classList.toggle('show');});
    }
    document.addEventListener('click',function(e){ if(window.innerWidth<=768 && sidebar && sidebar.classList.contains('show') && !sidebar.contains(e.target)){ sidebar.classList.remove('show'); } });
  })();
  </script>
  </body>
</html>