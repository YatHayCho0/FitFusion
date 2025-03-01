<?php
session_start();
include '../general/dbconn.php';

$userid = $_SESSION['userid'];

// Query for categories
$category_query = "SELECT category_name, category_image, category_description FROM workout_categoriestbl";
$category_result = mysqli_query($connection, $category_query);

$categories = [];
while ($category_row = mysqli_fetch_assoc($category_result)) {
    // Query to count how many times this category appears in workoutstbl
    $category_name = $category_row['category_name'];
    $count_query = "SELECT COUNT(*) AS count FROM workoutstbl WHERE workout_name = ? AND userid = ?";
    $stmt = mysqli_prepare($connection, $count_query);
    mysqli_stmt_bind_param($stmt, "si", $category_name, $userid);
    mysqli_stmt_execute($stmt);
    $count_result = mysqli_stmt_get_result($stmt);
    $count_row = mysqli_fetch_assoc($count_result);
    $registered_count = $count_row['count'];

    // If registered_count > 0, modify the description to show the count instead of "No registered workouts"
    if ($registered_count > 0) {
        $category_description = "✅Registered: $registered_count times";
    } else {
        $category_description = "No registered workouts";
    }

    // Update the new information if changing
    $update_query = "UPDATE workout_categoriestbl SET category_description = '$category_description' WHERE category_name = '$category_name'";
    mysqli_query($connection, $update_query);

    // Add the modified description and count to the category data
    $categories[] = [
        'category_name' => $category_row['category_name'],
        'category_image' => $category_row['category_image'],
        'category_description' => $category_description,  // Updated description
        'registered_count' => $registered_count  // Include count for potential future use
    ];
}

mysqli_close($connection);
echo json_encode($categories);
?>
