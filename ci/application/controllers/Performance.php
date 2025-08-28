<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Performance Dashboard Controller
 * 
 * Controller untuk menampilkan dashboard performance monitoring
 * Hanya boleh diakses di environment development
 */
class Performance extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        
        // Hanya bisa diakses di development environment
        if (ENVIRONMENT !== 'development') {
            show_404();
            return;
        }
        
        $this->load->helper('url');
        $this->load->helper('file');
    }
    
    /**
     * Dashboard utama performance
     */
    public function index() {
        $data = [
            'title' => 'Performance Monitor Dashboard',
            'performance_data' => $this->get_performance_data(),
            'summary' => $this->get_performance_summary()
        ];
        
        $this->load->view('performance/dashboard', $data);
    }
    
    /**
     * API endpoint untuk mendapatkan data performance (AJAX)
     */
    public function api() {
        header('Content-Type: application/json');
        
        $data = [
            'performance_data' => $this->get_performance_data(),
            'summary' => $this->get_performance_summary()
        ];
        
        echo json_encode($data);
    }
    
    /**
     * Hapus log performance (untuk cleanup)
     */
    public function clear_logs() {
        $log_dir = APPPATH . 'logs/performance/';
        
        if (is_dir($log_dir)) {
            $files = glob($log_dir . '*.log');
            $deleted = 0;
            
            foreach ($files as $file) {
                if (unlink($file)) {
                    $deleted++;
                }
            }
            
            echo json_encode([
                'status' => 'success',
                'message' => "Deleted {$deleted} log files",
                'deleted_count' => $deleted
            ]);
        } else {
            echo json_encode([
                'status' => 'error', 
                'message' => 'Log directory not found'
            ]);
        }
    }
    
    /**
     * Ambil data performance dari log files
     * 
     * @param int $limit Jumlah record yang ingin diambil
     * @return array Performance data
     */
    private function get_performance_data($limit = 100) {
        $log_dir = APPPATH . 'logs/performance/';
        $performance_data = [];
        
        if (!is_dir($log_dir)) {
            return $performance_data;
        }
        
        // Ambil file log hari ini dan kemarin
        $files = [
            $log_dir . 'performance_' . date('Y-m-d') . '.log',
            $log_dir . 'performance_' . date('Y-m-d', strtotime('-1 day')) . '.log'
        ];
        
        foreach ($files as $file) {
            if (file_exists($file)) {
                $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                
                foreach (array_reverse($lines) as $line) {
                    if (count($performance_data) >= $limit) {
                        break 2; // Break dari both loops
                    }
                    
                    $parts = explode(' | ', $line, 2);
                    if (count($parts) === 2) {
                        $data = json_decode($parts[1], true);
                        if ($data) {
                            $data['log_time'] = $parts[0];
                            $performance_data[] = $data;
                        }
                    }
                }
            }
        }
        
        return $performance_data;
    }
    
    /**
     * Buat summary statistics dari performance data
     * 
     * @return array Summary data
     */
    private function get_performance_summary() {
        $data = $this->get_performance_data(1000); // Ambil lebih banyak untuk analisis
        
        if (empty($data)) {
            return [
                'total_requests' => 0,
                'avg_execution_time' => 0,
                'max_execution_time' => 0,
                'min_execution_time' => 0,
                'slow_requests' => 0,
                'avg_memory_usage' => 0
            ];
        }
        
        $execution_times = array_column($data, 'execution_time_ms');
        $slow_requests = array_filter($execution_times, function($time) {
            return $time > 500; // > 500ms dianggap lambat
        });
        
        // Hitung memory usage (convert string ke bytes untuk kalkulasi)
        $memory_usages = [];
        foreach ($data as $item) {
            $memory_usages[] = $this->parse_memory_string($item['memory_usage']);
        }
        
        return [
            'total_requests' => count($data),
            'avg_execution_time' => round(array_sum($execution_times) / count($execution_times), 2),
            'max_execution_time' => max($execution_times),
            'min_execution_time' => min($execution_times),
            'slow_requests' => count($slow_requests),
            'slow_percentage' => round((count($slow_requests) / count($data)) * 100, 1),
            'avg_memory_usage' => $this->format_bytes(array_sum($memory_usages) / count($memory_usages)),
            'max_memory_usage' => $this->format_bytes(max($memory_usages))
        ];
    }
    
    /**
     * Parse memory string (e.g., "2.5 MB") ke bytes
     * 
     * @param string $memory_string
     * @return int bytes
     */
    private function parse_memory_string($memory_string) {
        $units = ['B' => 1, 'KB' => 1024, 'MB' => 1048576, 'GB' => 1073741824];
        
        if (preg_match('/^([\d.]+)\s*([A-Z]+)$/', $memory_string, $matches)) {
            $value = floatval($matches[1]);
            $unit = $matches[2];
            
            return isset($units[$unit]) ? $value * $units[$unit] : $value;
        }
        
        return 0;
    }
    
    /**
     * Format bytes ke string yang mudah dibaca
     * 
     * @param int $bytes
     * @param int $precision
     * @return string
     */
    private function format_bytes($bytes, $precision = 2) {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}