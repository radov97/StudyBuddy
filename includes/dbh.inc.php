<?php
/*
University details
$dbServeName = 'studdb.csc.liv.ac.uk';
$dbUsername = 'sgaradov';
$dbPassword = 'cristi132';
$dbName = 'sgaradov';
*/
session_start();
$dbServeName = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'studbud';

$conn = mysqli_connect($dbServeName, $dbUsername, $dbPassword, $dbName);