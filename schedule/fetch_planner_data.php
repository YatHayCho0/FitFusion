<?php
session_start();
include '../general/dbconn.php';

$userid = $_SESSION['userid'];

$query = "SELECT workout_name, workout_type, workout_date, workout_location, workout_notes FROM workoutstbl WHERE userid = ?";
$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, "i", $userid);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$calendar = [];
while ($row = mysqli_fetch_assoc($result)) {
    $dayData = [
        'date' => $row['workout_date'],
        'activity_name' => $row['workout_name'],
        'activity_class' => strtolower($row['workout_type']),
        'category' => $row['workout_type'],
        'location' => $row['workout_location'],
        'notes' => $row['workout_notes']

    ];

    $calendar[] = $dayData;
}

mysqli_close($connection);
echo json_encode($calendar);
?>
