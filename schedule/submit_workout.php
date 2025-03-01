<?php
session_start();
include '../general/dbconn.php'; 
include '../general/Header.php';

$firstname = isset($_SESSION['firstname']) ? $_SESSION['firstname'] : 'Your'; 
$userid = $_SESSION['userid'];

$formSubmitted = false;
$successMessage = '';
$errorMessage = '';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $workout_name = $_POST['workout_name'] ?? '';
    $workout_type = $_POST['workout_type'] ?? '';
    $workout_date = $_POST['workout_date'] ?? '';
    $workout_location = $_POST['workout_location'] ?? '';
    $workout_notes = $_POST['workout_notes'] ?? '';

    $sql = "INSERT INTO workoutstbl (workout_name, userid, workout_type, workout_date, workout_location, workout_notes)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($connection, $sql);

    mysqli_stmt_bind_param($stmt, "sissss", $workout_name, $userid, $workout_type, $workout_date, $workout_location, $workout_notes);

    if (mysqli_stmt_execute($stmt)) {
        $formSubmitted = true; // Set to true to show success message
        header("Location: submit_workout.php?success=1");
        exit();
    } else {
        $errorMessage = 'Error: ' . mysqli_error($connection);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($connection);
}

$showAlert = isset($_GET['success']) && $_GET['success'] == '1';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Workout</title>
    <link rel="stylesheet" href="submit.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../general/Navigation.css?v=<?php echo time(); ?>">
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="collage-container">
            <div class="collage-item">
                <img src="../images/workout 1.jpg" alt="Workout Image 1">
            </div>
            <div class="collage-item">
                <img src="../images/workout 6.jpg" alt="Workout Image 2">
            </div>
            <div class="collage-item">
                <img src="../images/workout 3.jpg" alt="Workout Image 3">
            </div>
            <div class="collage-item">
                <img src="../images/workout 4.jpg" alt="Workout Image 4">
            </div>
            <div class="collage-item">
                <img src="../images/workout 5.jpg" alt="Workout Image 5">
            </div>
        </div>
    </header>

    <div class="sidebar-title">
        <!-- NAVIGATION BAR  -->
        <div class="navigation-black">
            <nav class="bar">
                <ul>
                    <li><a href="../homepage/MainPage.php" class="navigation-black">Home</a></li>
                    
                    <li class="seperator">/</li>
                    <li><a href="schedule.php" class="navigation-black">Workout Schedule</a></li>
                    <li class="seperator">/</li>
                    <li><a href="" class="current navigation-black">Add New Workout</a></li>
                </ul>
            </nav>
        </div>
        <h1>Add New Workout</h1>
    </div>

    <div class="layout-container">
        <!-- Sidebar Section -->
        <aside class="sidebar">
            <div class="profile-section">
                <img src="show_image.php?userid=<?php echo $userid; ?>" alt="Profile Picture">
                <h1><?php echo $firstname; ?>'s Workout Planner</h1>
            </div>

            <div class="welcome-section">
                <h4>Welcome !<br>Today is a fresh start to unlock your potential. Let's get moving!</h4>
            </div>

            <!-- Navigation -->
            <nav class="navigations">
                <h3>Navigation</h3>
                <ul>
                    <li><a href="weekly.php">Fitness Program</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content for Adding New Workout -->
        <main class="main-content">
            <section class="add-workout-section">
                <h2>Workout Information</h2>

                <!-- Form to Add New Workout -->
                <form action="submit_workout.php" method="POST" class="add-workout-form">
                    <div class="form-group">
                    <label for="workout-name">Workout Name:</label>
                        <select id="workout-name" name="workout_name" required>
                            <option value="">Select workout</option>
                            <option value="Boxing">Boxing</option>
                            <option value="Yoga">Yoga</option>
                            <option value="Cardio">Cardio</option>
                            <option value="Barre">Barre</option>
                            <option value="Hiit">HIIT</option>
                            <option value="Dance">Dance</option>
                            <option value="Pilates">Pilates</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="workout-type">Workout Type:</label>
                        <select id="workout-type" name="workout_type" required>
                            <option value="">Select workout type</option>
                            <option value="Workout">Workout</option>
                            <option value="Wellness">Wellness</option>
                            <option value="Cardio">Cardio</option>
                            <option value="Fitness">Fitness</option>
                            <option value="Recovery">Recovery</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="workout-date">Date:</label>
                        <input type="date" id="workout-date" name="workout_date" required>
                    </div>

                    <div class="form-group">
                        <label for="workout-location">Location:</label>
                        <select id="workout-location" name="workout_location" required>
                            <option value="">Select location</option>
                            <option value="📍 Outdoors">📍 Outdoors</option>
                            <option value="🏋 Gym">🏋 Gym</option>
                            <option value="🏞 Park">🏞 Park</option>
                            <option value="🏊 Pool">🏊 Pool</option>
                            <option value="🚴‍♂ Road">🚴‍♂ Road</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="workout-notes">Notes:</label>
                        <textarea id="workout-notes" name="workout_notes" placeholder="Add any notes about your workout" rows="4"></textarea>
                    </div>

                    <button type="submit" class="submit-btn">Add Workout</button>
                </form>
            </section>
        </main>
    </div>

    <?php include '../general/Footer.php';?>

    <script src="submit.js"></script>
    <script>
        // Show success alert if the form was submitted successfully
        <?php if ($showAlert): ?>
            alert('Workout added successfully!');
            // After showing the alert, remove the query string to avoid showing the alert on refresh
            if (window.history.replaceState) {
                const url = new URL(window.location);
                url.searchParams.delete('success'); // Remove the 'success' parameter
                window.history.replaceState(null, '', url); // Update the URL without refreshing
            }
        <?php endif; ?>
    </script>
</body>
</html>