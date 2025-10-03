<?php
// 代码生成时间: 2025-10-03 21:04:47
// Load the Zend Framework autoloader
require_once 'vendor/autoload.php';

use Zend\Mvc\Application;
use Zend\Stdlib\ArrayUtils;
use Zend\Stdlib\ResponseInterface as Response;

// Define the configuration array
$config = ArrayUtils::merge(
    include 'config/application.config.php',
    include 'config/development.config.php'
);

// Run the application
Application::init($config)->run();
"}