<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CodeIgniter EMS - Employee Management System</title>
    <meta name="description" content="Modern Employee Management System with Performance Monitoring and RESTful API">
    <meta name="author" content="CodeIgniter EMS">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --bs-border-radius: 0.75rem;
            --transition-speed: 0.3s;
        }
        
        body {
            transition: all var(--transition-speed) ease;
        }
        
        .navbar-brand {
            font-weight: 600;
        }
        
        .card {
            border-radius: var(--bs-border-radius);
            transition: all var(--transition-speed) ease;
        }
        
        .btn {
            border-radius: calc(var(--bs-border-radius) / 2);
            transition: all var(--transition-speed) ease;
        }
        
        .form-control, .form-select {
            border-radius: calc(var(--bs-border-radius) / 2);
        }
        
        /* Smooth animations */
        * {
            scroll-behavior: smooth;
        }
        
        /* Loading states */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }
        
        /* Focus states */
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }
    </style>
</head>
<body>