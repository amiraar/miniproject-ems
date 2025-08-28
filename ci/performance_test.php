<?php
/**
 * Simple Performance Test Without Hooks
 * 
 * Ini adalah contoh sederhana bagaimana performance monitoring bekerja
 * tanpa menggunakan CodeIgniter hooks (untuk debugging)
 */

// Start performance monitoring
$start_time = microtime(true);
$start_memory = memory_get_usage(true);

echo "<h1>Performance Monitoring Test</h1>";
echo "<p>Starting performance measurement...</p>";

// Simulate some work
usleep(rand(10000, 100000)); // 10-100ms delay
$data = array_fill(0, 1000, 'test data'); // Allocate some memory

// Calculate performance
$execution_time = microtime(true) - $start_time;
$memory_used = memory_get_usage(true) - $start_memory;
$peak_memory = memory_get_peak_usage(true);

// Performance data
$performance_data = [
    'url' => $_SERVER['REQUEST_URI'] ?? 'test',
    'method' => $_SERVER['REQUEST_METHOD'] ?? 'GET',
    'execution_time_ms' => round($execution_time * 1000, 2),
    'memory_usage' => format_bytes($memory_used),
    'peak_memory' => format_bytes($peak_memory),
    'timestamp' => date('Y-m-d H:i:s'),
    'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'localhost'
];

echo "<h2>Performance Results:</h2>";
echo "<ul>";
foreach ($performance_data as $key => $value) {
    echo "<li><strong>" . ucfirst(str_replace('_', ' ', $key)) . ":</strong> $value</li>";
}
echo "</ul>";

// Save to log file (simulated)
$log_dir = __DIR__ . '/application/logs/performance/';
if (!is_dir($log_dir)) {
    mkdir($log_dir, 0755, true);
}

$log_file = $log_dir . 'performance_' . date('Y-m-d') . '.log';
$log_entry = date('Y-m-d H:i:s') . ' | ' . json_encode($performance_data) . PHP_EOL;
file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);

echo "<p><strong>Log saved to:</strong> $log_file</p>";

// Performance status
if ($execution_time > 0.1) {
    echo "<p style='color: red;'><strong>⚠️ WARNING:</strong> This request took longer than 100ms!</p>";
} else {
    echo "<p style='color: green;'><strong>✅ GOOD:</strong> Fast response time!</p>";
}

// Helper function
function format_bytes($size, $precision = 2) {
    $units = ['B', 'KB', 'MB', 'GB'];
    
    for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
        $size /= 1024;
    }
    
    return round($size, $precision) . ' ' . $units[$i];
}

echo "<hr>";
echo "<p><a href='performance_test.php'>🔄 Run Test Again</a></p>";
echo "<p><a href='performance_dashboard.php'>📊 View Dashboard</a></p>";
?>