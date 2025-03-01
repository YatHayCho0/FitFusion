<?php
session_start();

include '../general/dbconn.php';
include '../general/Header.php';


$firstname = isset($_SESSION['firstname']) ? $_SESSION['firstname'] : 'Your'; 
$userid = $_SESSION['userid'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness Program</title>
    <link rel="stylesheet" href="weekly.css?v=<?php echo time(); ?>">
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
                    <li><a href="" class="current navigation-black">Fitness Program</a></li>
                </ul>
            </nav>
        </div>
        <h1>Fitness Program</h1>
    </div>

    <div class="layout-container">
        <!-- Sidebar Section -->
        <aside class="sidebar">
            <div class="profile-section">
                <img src="show_image.php?userid=<?php echo $userid; ?>" alt="Profile Picture">
                <h1><?php echo $firstname; ?>'s Workout Planner</h1>
            </div>

            <div class="welcome-section">
                <h4>Welcome!<br>Today is a fresh start to unlock your potential. Let's get moving!</h4>
            </div>

            <div class="shortcuts">
                <h3>Shortcuts</h3>
                <ul>
                    <li><button class="shortcut-btn" onclick="goToAddWorkout()">Add New Workout</button></li>
                </ul>
            </div>
        </aside>

        <!-- Main Content Section -->
        <main class="main-content">
            <!-- Workout Categories -->
            <section class="workout-categories-section">
                <h2>Weekly Program</h2>
                <div class="category-tabs">
                    <span class="tab active">This Week</span>
                </div>

                <!-- Weekly Program Table -->
                <table class="weekly-program">
                    <thead>
                        <tr>
                            <th>🗓 Day</th>
                            <th>📌 Type</th>
                            <th>💪 Workout Category</th>
                            <th>📝 Notes</th>
                        </tr>
                    </thead>
                    <tbody id="weeklyProgramTable">
                        
                    </tbody>
                </table>
            </section>
        </main>
    </div>
    <?php include '../general/Footer.php';?>
    <script src="weekly.js"></script>
</body>
</html>