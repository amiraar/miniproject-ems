<nav class="top-navbar d-flex align-items-center px-4">
    <!-- Mobile Menu Toggle -->
    <button class="btn btn-outline-secondary d-md-none me-3" type="button" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>
    
    <!-- Page Title -->
    <h5 class="mb-0 me-auto">
        <i class="fas fa-tachometer-alt text-primary me-2"></i>
        Dashboard Overview
    </h5>
    
    <!-- User Info & Clock -->
    <div class="d-flex align-items-center">
        
        <div class="dropdown">
            <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="fas fa-user-circle me-2"></i>
                <?php echo $this->session->userdata('u_name') ?: 'Admin'; ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="<?php echo base_url(); ?>Home/logout">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                </a></li>
            </ul>
        </div>
    </div>
</nav>
