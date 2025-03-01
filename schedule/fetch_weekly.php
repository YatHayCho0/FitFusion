<?php

session_start();
include '../general/dbconn.php';

$currentDate = date('Y-m-d');

// Calculate the start and end date of the current week (Monday to Sunday)
$startDate = date('Y-m-d', strtotime('monday this week', strtotime($currentDate)));
$endDate = date('Y-m-d', strtotime('sunday this week', strtotime($currentDate)));

$userid = $_SESSION['userid'];

// Fetch the workout entries for the current week
$sql = "SELECT workout_name, workout_type, workout_notes, workout_date FROM workoutstbl 
        WHERE workout_date BETWEEN '$startDate' AND '$endDate' 
        AND userid = '$userid'  -- Filter by userid
        ORDER BY workout_date ASC";

$result = mysqli_query($connection, $sql);

// Initialize an empty array to store workout data
$workouts = [];

if ($result && mysqli_num_rows($result) > 0) {
    // Fetch all workouts and store them in an associative array
    $workouts = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Convert the result to JSON format
header('Content-Type: application/json');
echo json_encode($workouts);

mysqli_close($connection);
?>
