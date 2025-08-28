<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System - Login</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Theme CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/theme.css">
</head>
<body>
    <!-- Theme Toggle Button -->
    <button class="btn btn-primary theme-toggle" id="themeToggle" title="Toggle Dark/Light Mode">
        <i class="fas fa-moon" id="themeIcon"></i>
    </button>

<!-- Hero Section -->
<div class="hero-section">
    <div class="container">
        <div class="row align-items-center min-vh-100">
            <div class="col-lg-6">
                <div class="hero-content">
                    <h1 class="display-4 fw-bold text-white mb-4">
                        <i class="fas fa-building me-3"></i>
                        Employee Management System
                    </h1>
                    <p class="lead text-white-50 mb-4">
                        Streamline your workforce management with our comprehensive EMS solution. 
                        Track performance, manage departments, and optimize productivity.
                    </p>
                    <div class="feature-badges mb-4">
                        <span class="badge bg-light text-dark me-2 mb-2">
                            <i class="fas fa-chart-line me-1"></i>Performance Monitoring
                        </span>
                        <span class="badge bg-light text-dark me-2 mb-2">
                            <i class="fas fa-api me-1"></i>RESTful API
                        </span>
                        <span class="badge bg-light text-dark me-2 mb-2">
                            <i class="fas fa-users me-1"></i>Department Management
                        </span>
                        <span class="badge bg-light text-dark me-2 mb-2">
                            <i class="fas fa-mobile-alt me-1"></i>Responsive Design
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="login-card">
                    <div class="card shadow-lg border-0">
                        <div class="card-header bg-gradient text-blue text-center py-4">
                            <h3 class="mb-0">
                                <i class="fas fa-user-shield me-2"></i>
                                User Login
                            </h3>
                            <p class="mb-0 opacity-75">Access your dashboard</p>
                        </div>
                        <div class="card-body p-4">
                            <?php if(isset($error)): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <?= $error ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>
                            
                            <?php echo form_open('home/login_process'); ?>
                                <div class="form-floating mb-3">
                                    <input type="text" name="u_name" class="form-control" id="username" placeholder="Username" required>
                                    <label for="username">
                                        <i class="fas fa-user me-2"></i>Username
                                    </label>
                                </div>
                                
                                <div class="form-floating mb-4">
                                    <input type="password" name="u_pass" class="form-control" id="password" placeholder="Password" required>
                                    <label for="password">
                                        <i class="fas fa-lock me-2"></i>Password
                                    </label>
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <input type="submit" name="u_login" value="Login" class="btn btn-success btn-sm">
                                    <a href="<?php echo site_url('home/register'); ?>" class="btn btn-warning btn-sm">Register</a>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                        <div class="card-footer text-center bg-transparent border-0 py-3">
                            <small class="text-muted">
                                <i class="fas fa-shield-alt me-1"></i>
                                Secure login protected by encryption
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Access Section -->
<div class="quick-access-section py-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-12 mb-5">
                <h2 class="display-6 fw-bold">System Features</h2>
                <p class="text-muted">Explore what our EMS can do for you</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="feature-card card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon text-primary mb-3">
                            <i class="fas fa-chart-line fa-3x"></i>
                        </div>
                        <h5>Performance Dashboard</h5>
                        <p class="text-muted small">Real-time monitoring and analytics</p>
                        <a href="performance_dashboard.php" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-external-link-alt me-1"></i>View Dashboard
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="feature-card card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon text-success mb-3">
                            <i class="fas fa-code fa-3x"></i>
                        </div>
                        <h5>API Documentation</h5>
                        <p class="text-muted small">RESTful API endpoints & testing</p>
                        <a href="index.php/api_docs" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-book me-1"></i>View API Docs
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="feature-card card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon text-warning mb-3">
                            <i class="fas fa-users fa-3x"></i>
                        </div>
                        <h5>Employee Management</h5>
                        <p class="text-muted small">Manage staff and departments</p>
                        <span class="btn btn-outline-warning btn-sm disabled">
                            <i class="fas fa-lock me-1"></i>Login Required
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="feature-card card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon text-info mb-3">
                            <i class="fas fa-briefcase fa-3x"></i>
                        </div>
                        <h5>Job Management</h5>
                        <p class="text-muted small">Track positions and assignments</p>
                        <span class="btn btn-outline-info btn-sm disabled">
                            <i class="fas fa-lock me-1"></i>Login Required
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Theme Manager
    class ThemeManager {
        constructor() {
            this.theme = localStorage.getItem('theme') || 'light';
            this.toggleBtn = document.getElementById('themeToggle');
            this.themeIcon = document.getElementById('themeIcon');
            
            this.init();
        }
        
        init() {
            this.applyTheme(this.theme);
            this.toggleBtn.addEventListener('click', () => this.toggleTheme());
        }
        
        toggleTheme() {
            this.theme = this.theme === 'light' ? 'dark' : 'light';
            this.applyTheme(this.theme);
            localStorage.setItem('theme', this.theme);
        }
        
        applyTheme(theme) {
            document.documentElement.setAttribute('data-bs-theme', theme);
            
            if (theme === 'dark') {
                this.themeIcon.className = 'fas fa-sun';
                this.toggleBtn.title = 'Switch to Light Mode';
            } else {
                this.themeIcon.className = 'fas fa-moon';
                this.toggleBtn.title = 'Switch to Dark Mode';
            }
        }
    }
    
    // Initialize when DOM loads
    document.addEventListener('DOMContentLoaded', function() {
        new ThemeManager();
        
        // Add entrance animations
        const cards = document.querySelectorAll('.feature-card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.3s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100 * index);
        });
    });
</script>

<!-- Bootstrap 5 JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>