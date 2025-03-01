<?php
// db.php - Database connection file
$host = 'localhost'; // your database host (usually localhost)
$user = 'root';      // your database user
$password = '';      // your database password
$dbname = 'your_database'; // your database name

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

// Fetch data from the 'links' table
$sql = "SELECT text_video, link FROM liveWorkouts";
$result = $conn->query($sql);
?>
