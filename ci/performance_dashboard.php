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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Performance Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .fast { background-color: #d4edda; }
        .medium { background-color: #cce7ff; }
        .slow { background-color: #fff3cd; }
        .very-slow { background-color: #f8d7da; }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-4">
        <h1><i class="fas fa-tachometer-alt"></i> Simple Performance Dashboard</h1>
        
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
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title"><?= $total_requests ?></h5>
                            <p class="card-text">Total Requests</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title"><?= $avg_time ?>ms</h5>
                            <p class="card-text">Average Time</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title"><?= $max_time ?>ms</h5>
                            <p class="card-text">Slowest Request</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title"><?= $slow_requests ?></h5>
                            <p class="card-text">Slow Requests (>100ms)</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Requests Table -->
            <div class="card">
                <div class="card-header justify-content-between">
                    <h5>Recent Requests (Last 20)</h5>
                    <a href="performance_dashboard.php" class="btn btn-primary btn-sm">Refresh</a>
                    <a href="performance_test.php" class="btn btn-primary btn-sm">Run New Test</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>URL</th>
                                    <th>Response Time</th>
                                    <th>Memory</th>
                                    <th>Peak Memory</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (array_reverse(array_slice($performance_data, -20)) as $data): ?>
                                    <?php
                                    $row_class = '';
                                    if ($data['execution_time_ms'] > 500) {
                                        $row_class = 'very-slow';
                                        $status = 'Very Slow';
                                        $badge = 'danger';
                                    } elseif ($data['execution_time_ms'] > 200) {
                                        $row_class = 'slow';
                                        $status = 'Slow';
                                        $badge = 'warning';
                                    } elseif ($data['execution_time_ms'] > 100) {
                                        $row_class = 'medium';
                                        $status = 'Medium';
                                        $badge = 'info';
                                    } else {
                                        $row_class = 'fast';
                                        $status = 'Fast';
                                        $badge = 'success';
                                    }
                                    ?>
                                    <tr class="<?= $row_class ?>">
                                        <td><?= date('H:i:s', strtotime($data['timestamp'])) ?></td>
                                        <td><?= htmlspecialchars($data['url']) ?></td>
                                        <td><strong><?= $data['execution_time_ms'] ?>ms</strong></td>
                                        <td><?= $data['memory_usage'] ?></td>
                                        <td><?= $data['peak_memory'] ?></td>
                                        <td><span class="badge bg-<?= $badge ?>"><?= $status ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        <?php else: ?>
            <div class="alert alert-info">
                <h4>No Performance Data Yet</h4>
                <p>Performance log file not found. Run some tests first:</p>
                <a href="performance_test.php" class="btn btn-primary">Run Performance Test</a>
            </div>
        <?php endif; ?>
        
        <div class="mt-4">
            <h3>How Performance Monitoring Works:</h3>
            <div class="row">
                <div class="col-md-6">
                    <h5>1. Measurement Points:</h5>
                    <ul>
                        <li><strong>Start Time:</strong> Dicatat saat request dimulai</li>
                        <li><strong>Memory Usage:</strong> Diukur dari awal hingga akhir</li>
                        <li><strong>Execution Time:</strong> Total waktu processing</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h5>2. Performance Thresholds:</h5>
                    <ul>
                        <li><strong>Fast:</strong> &lt; 100ms (hijau)</li>
                        <li><strong>Medium:</strong> 100-200ms (biru)</li>
                        <li><strong>Slow:</strong> 200-500ms (kuning)</li>
                        <li><strong>Very Slow:</strong> &gt; 500ms (merah)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>