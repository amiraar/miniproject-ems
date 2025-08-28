<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Performance Monitor Hook
 * 
 * Fungsi:
 * - Mengukur waktu eksekusi halaman
 * - Memantau penggunaan memory
 * - Mencatat query yang lambat
 * - Logging request untuk analisis
 */
class Performance_monitor {
    
    private $start_time;
    private $start_memory;
    
    public function __construct() {
        // Tidak menggunakan get_instance() di constructor karena CI belum ready
    }
    
    /**
     * Dipanggil di awal request (pre_system)
     * Menandai waktu mulai dan memory usage
     */
    public function start_benchmark() {
        $this->start_time = microtime(true);
        $this->start_memory = memory_get_usage(true);
        
        // Log request start (hanya di development)
        if (ENVIRONMENT === 'development') {
            log_message('debug', '[PERFORMANCE] Request started: ' . ($_SERVER['REQUEST_URI'] ?? 'CLI'));
        }
    }
    
    /**
     * Dipanggil di akhir request (post_system)
     * Mengkalkulasi performance metrics dan menyimpan log
     */
    public function end_benchmark() {
        $execution_time = microtime(true) - $this->start_time;
        $memory_usage = memory_get_usage(true) - $this->start_memory;
        $peak_memory = memory_get_peak_usage(true);
        
        // Prepare performance data
        $performance_data = [
            'url' => $_SERVER['REQUEST_URI'] ?? 'CLI',
            'method' => $_SERVER['REQUEST_METHOD'] ?? 'CLI',
            'execution_time_ms' => round($execution_time * 1000, 2), // konversi ke milliseconds
            'memory_usage' => $this->format_bytes($memory_usage),
            'peak_memory' => $this->format_bytes($peak_memory),
            'timestamp' => date('Y-m-d H:i:s'),
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'localhost',
            'user_agent' => substr($_SERVER['HTTP_USER_AGENT'] ?? 'Unknown', 0, 100) // limit length
        ];
        
        // Alert untuk halaman yang lambat (>1000ms)
        if ($execution_time > 1.0) {
            log_message('error', '[PERFORMANCE ALERT] Slow page detected: ' . json_encode($performance_data));
        }
        
        // Warning untuk halaman agak lambat (>500ms)
        if ($execution_time > 0.5) {
            log_message('info', '[PERFORMANCE WARNING] Slow page: ' . json_encode($performance_data));
        }
        
        // Save performance log (hanya di development)
        if (ENVIRONMENT === 'development') {
            $this->save_performance_log($performance_data);
        }
        
        // Add performance header untuk debugging (development only)
        if (ENVIRONMENT === 'development' && !is_cli()) {
            // Gunakan native PHP header function karena CI output mungkin belum tersedia
            if (!headers_sent()) {
                header('X-Execution-Time: ' . round($execution_time * 1000, 2) . 'ms');
                header('X-Memory-Usage: ' . $this->format_bytes($memory_usage));
            }
        }
    }
    
    /**
     * Dipanggil sebelum controller dimuat (pre_controller)
     * Mencatat informasi request
     */
    public function log_request() {
        // Pastikan tidak di CLI mode
        if (php_sapi_name() === 'cli') {
            return;
        }
        
        $request_data = [
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'url' => $_SERVER['REQUEST_URI'] ?? '',
            'method' => $_SERVER['REQUEST_METHOD'] ?? 'GET',
            'user_agent' => substr($_SERVER['HTTP_USER_AGENT'] ?? 'Unknown', 0, 200),
            'referer' => $_SERVER['HTTP_REFERER'] ?? '',
            'timestamp' => date('Y-m-d H:i:s')
        ];
        
        // Gunakan log_message dari CodeIgniter (sudah tersedia di pre_controller)
        if (function_exists('log_message')) {
            log_message('info', '[REQUEST] ' . json_encode($request_data));
        }
    }
    
    /**
     * Format bytes ke format yang mudah dibaca
     * 
     * @param int $size Size in bytes
     * @param int $precision Decimal places
     * @return string Formatted size
     */
    private function format_bytes($size, $precision = 2) {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }
        
        return round($size, $precision) . ' ' . $units[$i];
    }
    
    /**
     * Simpan performance log ke file terpisah
     * File akan dibuat per hari untuk memudahkan analisis
     * 
     * @param array $data Performance data
     */
    private function save_performance_log($data) {
        $log_dir = APPPATH . 'logs/performance/';
        
        // Buat directory jika belum ada
        if (!is_dir($log_dir)) {
            mkdir($log_dir, 0755, true);
        }
        
        $log_file = $log_dir . 'performance_' . date('Y-m-d') . '.log';
        $log_entry = date('Y-m-d H:i:s') . ' | ' . json_encode($data) . PHP_EOL;
        
        // Gunakan file locking untuk mencegah corruption
        file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);
        
        // Cleanup old log files (hapus yang lebih dari 7 hari)
        $this->cleanup_old_logs($log_dir);
    }
    
    /**
     * Hapus log file yang lebih dari 7 hari
     * 
     * @param string $log_dir Directory log
     */
    private function cleanup_old_logs($log_dir) {
        $files = glob($log_dir . 'performance_*.log');
        $cutoff_time = time() - (7 * 24 * 60 * 60); // 7 hari yang lalu
        
        foreach ($files as $file) {
            if (filemtime($file) < $cutoff_time) {
                unlink($file);
            }
        }
    }
}