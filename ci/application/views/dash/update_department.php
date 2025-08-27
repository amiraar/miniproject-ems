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
            <a href="<?php echo site_url(); ?>department/view_department" class="btn btn-default" title="Back">
              <span class="hidden-xs">Back</span>
            </a>
          </div>
        </div>

        <div class="col-lg-9 col-md-9">
          <div class="panel panel-default">
            <div class="panel-heading">Update Department</div>
            <div class="panel-body">
              <?php echo form_open('department/update_process_department/'.$d_id, 'class="form-horizontal"'); ?>
                <?php

                $department_list = $this->db->get_where('department', array('d_id' => $d_id));

                if ($department_list->num_rows() > 0) {
                    foreach ($department_list->result() as $department)
                    { ?>
                
                <div class="form-group">
                  <label class="col-sm-2 control-label">Department Name</label>
                  <div class="col-sm-10">
                    <input type="text" name="d_name" class="form-control input-sm" value="<?php echo htmlspecialchars($department->d_name); ?>" placeholder="Department Name" required>
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" name="update_department" class="btn btn-sm btn-warning" value="Update Department">
                  </div>
                </div>

                <?php }
                } else {
                    echo '<div class="alert alert-danger">Department not found!</div>';
                }

                ?>
                
              </form>
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