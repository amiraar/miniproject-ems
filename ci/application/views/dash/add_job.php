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
    <title>Add Job - CodeIgniter EMS</title>
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
        <a href="<?php echo site_url(); ?>jobs/view_jobs" class="btn btn-outline-secondary btn-sm">Back</a>
      </div>
      <div class="card">
        <div class="card-header">Add Job</div>
        <div class="card-body">
              <?php echo form_open('jobs/add_job', 'class="form-horizontal"'); ?>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Job Name</label>
                  <div class="col-sm-10">
                    <input type="text" name="j_name" class="form-control input-sm" placeholder="Job Name">
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="col-sm-2 control-label">Department Name</label>
                  <div class="col-sm-10">
                    <select name="d_id" class="form-control input-sm" required>
                      <option value="">-- Select Department --</option>
                      <?php if (isset($departments) && !empty($departments)): ?>
                        <?php foreach ($departments as $department): ?>
                          <option value="<?php echo $department->d_id; ?>"><?php echo $department->d_name; ?></option>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <option value="">No departments available. Please add departments first.</option>
                      <?php endif; ?>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" name="add_job" class="btn btn-sm btn-success" value="Add Job">
                  </div>
                </div>
              </form>
        </div>
      </div>
    </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/dashboard.js"></script>
  </body>
</html>