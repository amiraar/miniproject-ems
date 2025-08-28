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
    <title>Add Department - CodeIgniter EMS</title>
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
        <a href="<?php echo site_url(); ?>department/view_department" class="btn btn-outline-secondary btn-sm">Back</a>
      </div>
      
      <div class="card">
        <div class="card-header">Add Department</div>
        <div class="card-body">
              <?php echo form_open('department/add_department', 'class="form-horizontal"'); ?>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Department Name</label>
                  <div class="col-sm-10">
                    <input type="text" name="d_name" class="form-control input-sm" placeholder="Department Name">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" name="add_department" class="btn btn-sm btn-success" value="Add Department">
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