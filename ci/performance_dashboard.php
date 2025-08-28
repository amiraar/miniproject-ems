<?php
/**
 * Simple Performance Dashboard
 * 
 * Dashboard sederhana untuk melihat hasil performance monitoring
 */

$log_dir = __DIR__ . '/application/logs/performance/';
$log_file = $log_dir . 'performance_' . date('Y-m-d') . '.log';

?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📊 Performance Dashboard - CodeIgniter EMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/theme.css">
    <style>
        /* Performance Dashboard Specific Styles */
        .fast { 
            background-color: var(--fast-bg, #d1e7dd);
            border: 1px solid var(--fast-border, #badbcc);
            color: var(--fast-text, #0f5132);
        }
        .medium { 
            background-color: var(--medium-bg, #cff4fc);
            border: 1px solid var(--medium-border, #b6effb);
            color: var(--medium-text, #055160);
        }
        .slow { 
            background-color: var(--slow-bg, #fff3cd);
            border: 1px solid var(--slow-border, #ffecb5);
            color: var(--slow-text, #664d03);
        }
        .very-slow { 
            background-color: var(--very-slow-bg, #f8d7da);
            border: 1px solid var(--very-slow-border, #f5c2c7);
            color: var(--very-slow-text, #842029);
        }
        
        /* Dark Theme Performance Colors */
        [data-bs-theme="dark"] .fast { 
            background-color: #0f5132;
            border: 1px solid #1e7e34;
            color: #d1e7dd;
        }
        [data-bs-theme="dark"] .medium { 
            background-color: #055160;
            border: 1px solid #0c7985;
            color: #cff4fc;
        }
        [data-bs-theme="dark"] .slow { 
            background-color: #664d03;
            border: 1px solid #997404;
            color: #fff3cd;
        }
        [data-bs-theme="dark"] .very-slow { 
            background-color: #842029;
            border: 1px solid #a02834;
            color: #f8d7da;
        }
    </style>
</head>
<body>
    <!-- Theme Toggle Button -->
    <button class="btn btn-primary theme-toggle" id="themeToggle" title="Toggle Dark/Light Mode">
        <i class="fas fa-moon" id="themeIcon"></i>
    </button>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg mb-4">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-chart-line me-2"></i>
                CodeIgniter EMS
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="index.php/api_docs">
                    <i class="fas fa-book me-1"></i>API Docs
                </a>
                <a class="nav-link" href="performance_test.php">
                    <i class="fas fa-flask me-1"></i>Performance Test
                </a>
            </div>
        </div>
    </nav>

    <div class="container">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="text-center">
                    <h1 class="display-5 fw-bold">
                        <i class="fas fa-tachometer-alt text-primary me-3"></i>
                        Performance Dashboard
                    </h1>
                    <p class="lead text-muted">
                        Real-time monitoring and analytics for CodeIgniter EMS
                    </p>
                </div>
            </div>
        </div>
        
        <?php if (file_exists($log_file)): ?>
            <?php
            $lines = file($log_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $performance_data = [];
            
            foreach ($lines as $line) {
                $parts = explode(' | ', $line, 2);
                if (count($parts) === 2) {
                    $data = json_decode($parts[1], true);
                    if ($data) {
                        $data['log_time'] = $parts[0];
                        $performance_data[] = $data;
                    }
                }
            }
            
            $total_requests = count($performance_data);
            $execution_times = array_column($performance_data, 'execution_time_ms');
            $avg_time = $total_requests > 0 ? round(array_sum($execution_times) / $total_requests, 2) : 0;
            $max_time = $total_requests > 0 ? max($execution_times) : 0;
            $slow_requests = count(array_filter($execution_times, function($time) { return $time > 100; }));
            ?>
            
            <!-- Summary Cards -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card stats-card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="d-flex align-items-center justify-content-center mb-3">
                                <div class="bg-primary bg-gradient rounded-circle p-3">
                                    <i class="fas fa-chart-bar text-white fa-lg"></i>
                                </div>
                            </div>
                            <h3 class="fw-bold text-primary"><?= number_format($total_requests) ?></h3>
                            <p class="text-muted mb-0">Total Requests</p>
                            <small class="text-success">
                                <i class="fas fa-arrow-up"></i> Today
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card stats-card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="d-flex align-items-center justify-content-center mb-3">
                                <div class="bg-success bg-gradient rounded-circle p-3">
                                    <i class="fas fa-clock text-white fa-lg"></i>
                                </div>
                            </div>
                            <h3 class="fw-bold text-success"><?= $avg_time ?>ms</h3>
                            <p class="text-muted mb-0">Average Response</p>
                            <small class="<?= $avg_time < 100 ? 'text-success' : ($avg_time < 200 ? 'text-warning' : 'text-danger') ?>">
                                <i class="fas fa-<?= $avg_time < 100 ? 'check' : ($avg_time < 200 ? 'exclamation' : 'times') ?>"></i>
                                <?= $avg_time < 100 ? 'Excellent' : ($avg_time < 200 ? 'Good' : 'Needs Improvement') ?>
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card stats-card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="d-flex align-items-center justify-content-center mb-3">
                                <div class="bg-warning bg-gradient rounded-circle p-3">
                                    <i class="fas fa-stopwatch text-white fa-lg"></i>
                                </div>
                            </div>
                            <h3 class="fw-bold text-warning"><?= $max_time ?>ms</h3>
                            <p class="text-muted mb-0">Slowest Request</p>
                            <small class="<?= $max_time < 200 ? 'text-success' : ($max_time < 500 ? 'text-warning' : 'text-danger') ?>">
                                <i class="fas fa-<?= $max_time < 200 ? 'check' : ($max_time < 500 ? 'exclamation' : 'times') ?>"></i>
                                Peak Performance
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card stats-card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="d-flex align-items-center justify-content-center mb-3">
                                <div class="bg-danger bg-gradient rounded-circle p-3">
                                    <i class="fas fa-exclamation-triangle text-white fa-lg"></i>
                                </div>
                            </div>
                            <h3 class="fw-bold text-danger"><?= $slow_requests ?></h3>
                            <p class="text-muted mb-0">Slow Requests</p>
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i> >100ms threshold
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Requests Table -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-transparent border-bottom-0 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-list-alt me-2 text-primary"></i>
                        Recent Performance Logs
                    </h4>
                    <div class="d-flex gap-2">
                        <span class="badge bg-success">Last 20 requests</span>
                        <a href="performance_test.php" class="btn btn-primary btn-sm">
                            <i class="fas fa-flask me-1"></i>Run New Test
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 ps-4">
                                        <i class="fas fa-clock me-2"></i>Time
                                    </th>
                                    <th class="border-0">
                                        <i class="fas fa-link me-2"></i>URL
                                    </th>
                                    <th class="border-0">
                                        <i class="fas fa-tachometer-alt me-2"></i>Response Time
                                    </th>
                                    <th class="border-0">
                                        <i class="fas fa-memory me-2"></i>Memory
                                    </th>
                                    <th class="border-0">
                                        <i class="fas fa-chart-line me-2"></i>Peak Memory
                                    </th>
                                    <th class="border-0 pe-4">
                                        <i class="fas fa-flag me-2"></i>Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (array_reverse(array_slice($performance_data, -20)) as $data): ?>
                                    <?php
                                    $row_class = '';
                                    if ($data['execution_time_ms'] > 500) {
                                        $row_class = 'very-slow performance-card';
                                        $status = 'Very Slow';
                                        $badge = 'danger';
                                        $icon = 'fas fa-exclamation-triangle';
                                    } elseif ($data['execution_time_ms'] > 200) {
                                        $row_class = 'slow performance-card';
                                        $status = 'Slow';
                                        $badge = 'warning';
                                        $icon = 'fas fa-exclamation-circle';
                                    } elseif ($data['execution_time_ms'] > 100) {
                                        $row_class = 'medium performance-card';
                                        $status = 'Medium';
                                        $badge = 'info';
                                        $icon = 'fas fa-info-circle';
                                    } else {
                                        $row_class = 'fast performance-card';
                                        $status = 'Fast';
                                        $badge = 'success';
                                        $icon = 'fas fa-check-circle';
                                    }
                                    ?>
                                    <tr class="<?= $row_class ?>">
                                        <td class="ps-4 fw-medium">
                                            <?= date('H:i:s', strtotime($data['timestamp'])) ?>
                                        </td>
                                        <td class="text-truncate" style="max-width: 200px;" title="<?= htmlspecialchars($data['url']) ?>">
                                            <code class="small"><?= htmlspecialchars($data['url']) ?></code>
                                        </td>
                                        <td>
                                            <span class="fw-bold"><?= $data['execution_time_ms'] ?>ms</span>
                                        </td>
                                        <td class="small text-muted"><?= $data['memory_usage'] ?></td>
                                        <td class="small text-muted"><?= $data['peak_memory'] ?></td>
                                        <td class="pe-4">
                                            <span class="badge bg-<?= $badge ?> d-flex align-items-center" style="width: fit-content;">
                                                <i class="<?= $icon ?> me-1"></i>
                                                <?= $status ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        <?php else: ?>
            <!-- No Data Available -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0 text-center">
                        <div class="card-body py-5">
                            <div class="mb-4">
                                <i class="fas fa-chart-line text-muted" style="font-size: 4rem;"></i>
                            </div>
                            <h3 class="text-muted">No Performance Data Available</h3>
                            <p class="text-muted">
                                Performance logs will appear here after you make some requests to the application.
                            </p>
                            <div class="d-flex justify-content-center gap-3">
                                <a href="performance_test.php" class="btn btn-primary">
                                    <i class="fas fa-flask me-2"></i>Run Performance Test
                                </a>
                                <a href="index.php" class="btn btn-outline-primary">
                                    <i class="fas fa-home me-2"></i>Go to Main App
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- How It Works Section -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-transparent border-bottom-0">
                        <h3 class="mb-0">
                            <i class="fas fa-info-circle text-primary me-2"></i>
                            How Performance Monitoring Works
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <h5 class="text-primary">
                                    <i class="fas fa-cogs me-2"></i>Measurement Points
                                </h5>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item border-0 ps-0">
                                        <i class="fas fa-play text-success me-2"></i>
                                        <strong>Start Time:</strong> Recorded when request begins
                                    </li>
                                    <li class="list-group-item border-0 ps-0">
                                        <i class="fas fa-memory text-info me-2"></i>
                                        <strong>Memory Usage:</strong> Measured from start to finish
                                    </li>
                                    <li class="list-group-item border-0 ps-0">
                                        <i class="fas fa-stopwatch text-warning me-2"></i>
                                        <strong>Execution Time:</strong> Total processing time
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-6">
                                <h5 class="text-primary">
                                    <i class="fas fa-flag-checkered me-2"></i>Performance Thresholds
                                </h5>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item border-0 ps-0">
                                        <span class="badge bg-success me-2">Fast</span>
                                        <strong>&lt; 100ms</strong> - Excellent performance
                                    </li>
                                    <li class="list-group-item border-0 ps-0">
                                        <span class="badge bg-info me-2">Medium</span>
                                        <strong>100-200ms</strong> - Good performance
                                    </li>
                                    <li class="list-group-item border-0 ps-0">
                                        <span class="badge bg-warning me-2">Slow</span>
                                        <strong>200-500ms</strong> - Needs attention
                                    </li>
                                    <li class="list-group-item border-0 ps-0">
                                        <span class="badge bg-danger me-2">Very Slow</span>
                                        <strong>&gt; 500ms</strong> - Requires optimization
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Theme Toggle Script -->
    <script>
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
                
                // Auto-refresh every 30 seconds
                setInterval(() => {
                    if (!document.hidden) {
                        window.location.reload();
                    }
                }, 30000);
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
        
        // Initialize theme manager when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            new ThemeManager();
        });
        
        // Add smooth scroll behavior
        document.documentElement.style.scrollBehavior = 'smooth';
        
        // Add loading state for tables
        document.addEventListener('DOMContentLoaded', function() {
            const tables = document.querySelectorAll('.table-responsive');
            tables.forEach(table => {
                table.style.opacity = '0';
                table.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    table.style.transition = 'all 0.3s ease';
                    table.style.opacity = '1';
                    table.style.transform = 'translateY(0)';
                }, 100);
            });
        });
    </script>
</body>
</html>