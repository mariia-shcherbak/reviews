<?php
/**
 * Configuration File
 *
 * This file contains all the configuration settings for the application.
 */

 // Include necessary files
require_once __DIR__ . '/../app/core/Database.php';
require_once '../app/core/Controller.php';

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'shchemar');
define('DB_PASS', 'webove aplikace');
define('DB_NAME', 'shchemar');

// Base URL configuration
define('BASE_URL', 'https://zwa.toad.cz/~shchemar/reviews/public');

// Base URL configuration
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session
session_start();