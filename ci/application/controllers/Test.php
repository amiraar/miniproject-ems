<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {
    
    public function index() {
        echo "Hello World! Performance monitoring test.";
        echo "<br>Time: " . date('Y-m-d H:i:s');
        echo "<br>Memory usage: " . round(memory_get_usage(true) / 1024 / 1024, 2) . " MB";
        
        // Test logging
        log_message('info', 'Test controller accessed');
    }
    
    public function performance() {
        redirect('performance');
    }
}