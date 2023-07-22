<?php

// Database credentials
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'gamereview';
$port = '3306';

// Create a new MySQLi instance
$con = mysqli_connect($hostname, $username, $password, $database);

// Check the connection
if (!$con) {
    die('Connection failed: ');
}
