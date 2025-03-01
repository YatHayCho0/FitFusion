<?php
//step1 - create a connection to your database
$hostname = 'localhost'; //127.0.0.1
$user = 'root';
$password = '';
$database  = 'fitfusion';

$connection = mysqli_connect($hostname, $user, $password, $database);

if ($connection === false) {
    die('Connection failed!' . mysqli_connect_error());
}