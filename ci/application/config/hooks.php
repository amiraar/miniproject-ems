<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/

/*
| -------------------------------------------------------------------------
| Performance Monitor Hooks
| -------------------------------------------------------------------------
| Hooks untuk memantau performance aplikasi:
| - pre_controller: Dipanggil sebelum controller dimuat (CI sudah ready)
| - post_system: Dipanggil setelah system selesai
| 
| Note: Menghindari pre_system karena CI core belum ready
*/

// Hook untuk memulai monitoring setelah CI ready
$hook['pre_controller'] = array(
    'class'    => 'Performance_monitor', 
    'function' => 'start_benchmark',
    'filename' => 'Performance_monitor.php',
    'filepath' => 'hooks'
);

// Hook untuk log request
$hook['pre_controller'][] = array(
    'class'    => 'Performance_monitor', 
    'function' => 'log_request',
    'filename' => 'Performance_monitor.php',
    'filepath' => 'hooks'
);

// Hook untuk mengakhiri monitoring di akhir request
$hook['post_system'] = array(
    'class'    => 'Performance_monitor',
    'function' => 'end_benchmark', 
    'filename' => 'Performance_monitor.php',
    'filepath' => 'hooks'
);