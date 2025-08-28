<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .performance-card {
            transition: transform 0.2s;
        }
        .performance-card:hover {
            transform: translateY(-2px);
        }
        .slow-request {
            background-color: #fff3cd;
        }
        .fast-request {
            background-color: #d4edda;
        }
        .medium-request {
            background-color: #cce7ff;
        }
        .chart-container {
            position: relative;
            height: 300px;
            margin: 20px 0;
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">
                <i class="fas fa-tachometer-alt"></i> Performance Monitor Dashboard
            </span>
            <span class="navbar-text">
                <small>Environment: <?= ENVIRONMENT ?></small>
            </span>
        </div>
    </nav>

    <div class="container-fluid mt-4">
        <!-- Performance Summary Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card performance-card text-center">
                    <div class="card-body">
                        <i class="fas fa-globe fa-2x text-primary mb-2"></i>
                        <h5 class="card-title"><?= $summary['total_requests'] ?></h5>
                        <p class="card-text text-muted">Total Requests</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card performance-card text-center">
                    <div class="card-body">
                        <i class="fas fa-clock fa-2x text-success mb-2"></i>
                        <h5 class="card-title"><?= $summary['avg_execution_time'] ?>ms</h5>
                        <p class="card-text text-muted">Avg Response Time</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card performance-card text-center">
                    <div class="card-body">
                        <i class="fas fa-exclamation-triangle fa-2x text-warning mb-2"></i>
                        <h5 class="card-title"><?= $summary['slow_requests'] ?> (<?= $summary['slow_percentage'] ?>%)</h5>
                        <p class="card-text text-muted">Slow Requests</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card performance-card text-center">
                    <div class="card-body">
                        <i class="fas fa-memory fa-2x text-info mb-2"></i>
                        <h5 class="card-title"><?= $summary['avg_memory_usage'] ?></h5>
                        <p class="card-text text-muted">Avg Memory Usage</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-chart-line"></i> Performance Summary</h5>
                        <div>
                            <button class="btn btn-outline-primary btn-sm" onclick="refreshData()">
                                <i class="fas fa-sync-alt"></i> Refresh
                            </button>
                            <button class="btn btn-outline-danger btn-sm" onclick="clearLogs()">
                                <i class="fas fa-trash"></i> Clear Logs
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Fastest Request:</strong> <?= $summary['min_execution_time'] ?>ms</p>
                                <p><strong>Slowest Request:</strong> <?= $summary['max_execution_time'] ?>ms</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Max Memory Usage:</strong> <?= $summary['max_memory_usage'] ?></p>
                                <p><strong>Performance Status:</strong> 
                                    <?php if ($summary['slow_percentage'] < 10): ?>
                                        <span class="badge bg-success">Excellent</span>
                                    <?php elseif ($summary['slow_percentage'] < 25): ?>
                                        <span class="badge bg-warning">Good</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Needs Attention</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Requests Table -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-list"></i> Recent Requests (Last 50)</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Time</th>
                                        <th>URL</th>
                                        <th>Method</th>
                                        <th>Response Time</th>
                                        <th>Memory</th>
                                        <th>IP</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($performance_data)): ?>
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">
                                                <i class="fas fa-info-circle"></i> No performance data available yet. 
                                                Make some requests to see data here.
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach (array_slice($performance_data, 0, 50) as $data): ?>
                                            <?php
                                            $row_class = '';
                                            if ($data['execution_time_ms'] > 1000) {
                                                $row_class = 'slow-request';
                                            } elseif ($data['execution_time_ms'] < 200) {
                                                $row_class = 'fast-request';
                                            } else {
                                                $row_class = 'medium-request';
                                            }
                                            ?>
                                            <tr class="<?= $row_class ?>">
                                                <td>
                                                    <small><?= date('H:i:s', strtotime($data['timestamp'])) ?></small>
                                                </td>
                                                <td>
                                                    <span class="text-truncate d-inline-block" style="max-width: 200px;" title="<?= htmlspecialchars($data['url']) ?>">
                                                        <?= htmlspecialchars($data['url']) ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-<?= $data['method'] === 'GET' ? 'primary' : ($data['method'] === 'POST' ? 'success' : 'secondary') ?>">
                                                        <?= $data['method'] ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <strong><?= $data['execution_time_ms'] ?>ms</strong>
                                                    <?php if ($data['execution_time_ms'] > 1000): ?>
                                                        <i class="fas fa-exclamation-triangle text-danger ms-1" title="Slow request"></i>
                                                    <?php elseif ($data['execution_time_ms'] < 200): ?>
                                                        <i class="fas fa-check text-success ms-1" title="Fast request"></i>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?= $data['memory_usage'] ?></td>
                                                <td><small><?= $data['ip_address'] ?></small></td>
                                                <td>
                                                    <?php if ($data['execution_time_ms'] > 1000): ?>
                                                        <span class="badge bg-danger">Slow</span>
                                                    <?php elseif ($data['execution_time_ms'] > 500): ?>
                                                        <span class="badge bg-warning">Medium</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-success">Fast</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto refresh setiap 30 detik
        setInterval(refreshData, 30000);
        
        function refreshData() {
            location.reload();
        }
        
        function clearLogs() {
            if (confirm('Are you sure you want to clear all performance logs?')) {
                fetch('<?= base_url('performance/clear_logs') ?>')
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        if (data.status === 'success') {
                            location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error clearing logs');
                    });
            }
        }
        
        // Highlight baris berdasarkan performance
        document.querySelectorAll('tbody tr').forEach(row => {
            const timeCell = row.cells[3];
            if (timeCell) {
                const time = parseFloat(timeCell.textContent);
                if (time > 1000) {
                    row.classList.add('table-danger');
                } else if (time > 500) {
                    row.classList.add('table-warning');
                }
            }
        });
    </script>
</body>
</html>