<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - CodeIgniter EMS</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom Theme CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/theme.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/dashboard.css">
</head>

<body>

    <!-- Sidebar -->
    <?php $this->load->view('dash/inc/sidebar'); ?>
    <!-- /Sidebar -->
    
    <!-- Top Navbar -->
    <?php $this->load->view('dash/inc/topnav'); ?>
    <!-- /Top Navbar -->
    
    <!-- Main Content -->
    <main class="main-content">
        <!-- Welcome Section -->
        <div class="welcome-card">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="h3 mb-2">Welcome back, <?php echo $this->session->userdata('u_name') ?: 'User'; ?>!</h2>
                    <p class="mb-0 opacity-75">Here's what's happening with your employee management system today.</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <small class="opacity-75"><?php echo date('l, F j, Y'); ?></small>
                </div>
            </div>
        </div>
        
        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card stats-card primary">
                    <div class="card-body">
                        <div class="stats-icon primary">
                            <i class="fas fa-users"></i>
                        </div>
						<?php $employees_count = $this->db->count_all('employees'); ?>
                        <h3 class="mb-1"><?php echo isset($employees_count) ? $employees_count : '0'; ?></h3>
                        <p class="text-muted mb-0">Total Employees</p>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6">
                <div class="card stats-card success">
                    <div class="card-body">
                        <div class="stats-icon success">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <?php $jobs_count = $this->db->count_all('jobs'); ?>
                        <h3 class="mb-1"><?php echo isset($jobs_count) ? $jobs_count : '0'; ?></h3>
                        <p class="text-muted mb-0">Active Jobs</p>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6">
                <div class="card stats-card warning">
                    <div class="card-body">
                        <div class="stats-icon warning">
                            <i class="fas fa-building"></i>
                        </div>
						<?php $departments_count = $this->db->count_all('department'); ?>
                        <h3 class="mb-1"><?php echo isset($departments_count) ? $departments_count : '0'; ?></h3>
                        <p class="text-muted mb-0">Departments</p>
                    </div>
                </div>
            </div>
            
        </div>
        
        <!-- Quick Actions & Recent Activity -->
        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="card h-100">
                    <div class="card-header bg-transparent border-0 pb-0">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-bolt text-warning me-2"></i>
                            Quick Actions
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="quick-action-card card text-center p-3" onclick="location.href='<?php echo base_url(); ?>employees/add_employee'">
                                    <div class="stats-icon primary mx-auto mb-2" style="width: 50px; height: 50px;">
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                    <h6>Add Employee</h6>
                                    <small class="text-muted">Register new employee</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="quick-action-card card text-center p-3" onclick="location.href='<?php echo base_url(); ?>jobs'">
                                    <div class="stats-icon success mx-auto mb-2" style="width: 50px; height: 50px;">
                                        <i class="fas fa-plus-circle"></i>
                                    </div>
                                    <h6>Create Job</h6>
                                    <small class="text-muted">Post new job opening</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="quick-action-card card text-center p-3" onclick="location.href='<?php echo base_url(); ?>department'">
                                    <div class="stats-icon warning mx-auto mb-2" style="width: 50px; height: 50px;">
                                        <i class="fas fa-building"></i>
                                    </div>
                                    <h6>Add Department</h6>
                                    <small class="text-muted">Create new department</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <!-- Theme Toggle Button (Bottom Right) -->
    <button class="theme-toggle" id="themeToggle" type="button">
        <i class="fas fa-moon" id="themeIcon"></i>
    </button>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/dashboard.js"></script>
</body>
</html>