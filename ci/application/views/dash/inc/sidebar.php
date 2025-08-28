<nav class="sidebar">
	<?php 
	    // Normalize current route for reliable active-state detection
	    $currentClass = isset($this->router) ? strtolower($this->router->class) : strtolower(uri_string());
	?>
	<div class="sidebar-header">
		<h4 class="mb-0">
			<i class="fas fa-building text-primary me-2"></i>
			<span class="fw-bold">CodeIgniter EMS</span>
		</h4>
		<small class="text-muted">Employee Management</small>
	</div>
    
	<div class="sidebar-nav">
		<ul class="nav flex-column">
			<li class="nav-item">
				<a class="nav-link <?php echo ($currentClass === 'dash') ? 'active' : ''; ?>" href="<?php echo base_url(); ?>Dash">
					<i class="fas fa-home"></i>
					<span>Dashboard</span>
				</a>
			</li>
            
			<li class="nav-item">
				<a class="nav-link <?php echo ($currentClass === 'employees') ? 'active' : ''; ?>" href="<?php echo base_url(); ?>Employees">
					<i class="fas fa-users"></i>
					<span>Employees</span>
					<span class="badge bg-primary ms-auto"><?php echo $this->db->count_all('employees') ?: 0; ?></span>
				</a>
			</li>
            
			<li class="nav-item">
				<a class="nav-link <?php echo ($currentClass === 'jobs') ? 'active' : ''; ?>" href="<?php echo base_url(); ?>Jobs">
					<i class="fas fa-briefcase"></i>
					<span>Jobs</span>
					<span class="badge bg-success ms-auto"><?php echo $this->db->count_all('jobs') ?: 0; ?></span>
				</a>
			</li>
            
			<li class="nav-item">
				<a class="nav-link <?php echo ($currentClass === 'department') ? 'active' : ''; ?>" href="<?php echo base_url(); ?>Department">
					<i class="fas fa-building"></i>
					<span>Departments</span>
					<span class="badge bg-warning ms-auto"><?php echo $this->db->count_all('department') ?: 0; ?></span>
				</a>
			</li>
            
			<li class="nav-item"><hr class="my-3"></li>
            
			<li class="nav-item">
				<a class="nav-link <?php echo (strpos(strtolower(uri_string()), 'performance_dashboard') !== false) ? 'active' : ''; ?>" href="<?php echo base_url(); ?>performance_dashboard.php">
					<i class="fas fa-chart-line"></i>
					<span>Performance</span>
				</a>
			</li>
            
			<li class="nav-item">
				<a class="nav-link <?php echo (strpos(strtolower(uri_string()), 'test') !== false) ? 'active' : ''; ?>" href="<?php echo base_url(); ?>performance_test.php">
					<i class="fas fa-cog"></i>
					<span>System Test</span>
				</a>
			</li>
            
			<li class="nav-item mt-auto"><hr class="my-3"></li>
            
			<li class="nav-item">
				<a class="nav-link text-danger" href="<?php echo base_url(); ?>Home/logout">
					<i class="fas fa-sign-out-alt"></i>
					<span>Logout</span>
				</a>
			</li>
			
		</ul>
	</div>
</nav>