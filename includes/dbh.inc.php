<?php

session_start();
$dbServeName = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'studbud';

$conn = mysqli_connect($dbServeName, $dbUsername, $dbPassword, $dbName);