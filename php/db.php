<?php

// Database credentials
$hostnameDB = 'localhost';
$usernameDB = 'root';
$passwordDB = '';
$databaseDB = 'gamereview';
$portDB = '3306';

// Create a new MySQLi instance
$con = mysqli_connect($hostnameDB, $usernameDB, $passwordDB, $databaseDB);

// Check the connection
if (!$con) {
    die('Connection failed: ');
}
