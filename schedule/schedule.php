<?php
session_start();

include '../general/dbconn.php';
include '../general/Header.php';

if (!isset($_SESSION['userid'])) {
    header('Location: ../login/login.php');
    exit();
}

// firstname display in Workout Schedule
$firstname = isset($_SESSION['firstname']) ? $_SESSION['firstname'] : 'Your'; 
$userid = $_SESSION['userid'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workout Planner</title>
    <link rel="stylesheet" href="schedule.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../general/Navigation.css?v=<?php echo time(); ?>">
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="collage-container">
            <!-- Images Collage -->
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

            <!-- Title Over Images -->
            <div class="header-title">
                <h1>Workout Schedule</h1>
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
                    <li><a href="" class="current navigation-black">Workout Schedule</a></li>
                </ul>
            </nav>
        </div>
        <h1>Workout Schedule</h1>
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

            <div class="shortcuts">
                <h3>Shortcuts</h3>
                <ul>
                    <li><button class="shortcut-btn" onclick="goToAddWorkout()">Add New Workout</button></li>
                </ul>
            </div>

            <nav class="navigations">
                <h3>Navigation</h3>
                <ul>
                    <li><a href="weekly.php">Fitness Program</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content Section -->
        <main class="main-content">
            <!-- Workout Categories -->
            <section class="workout-categories-section">
                <h2>Workout Categories</h2>
                <div class="category-tabs">
                    <div class="tab all" onclick="handleTabClick('all')">All Categories</div>
                    <div class="tab registered" onclick="handleTabClick('registered')">Registered</div>
                </div>
                <div class="workout-categories">
                    
                </div>
            </section>
            <section class="fitness-planner-section">
                <h2>Fitness Planner</h2>
                <div class="fitness-tabs">
                    <span class="fitness active">📆 Calendar</span>
                </div>
                <!-- Add the centered month-year title below the calendar header -->
                <div id="calendar-header">
                    <button onclick="prevMonth()">◀</button>
                    <span id="month-year"></span>
                    <button onclick="nextMonth()">▶</button>
                </div>
                <div class="fitness-planner">
                    <table class="planner-table">
                        <thead>
                            <tr>
                                <th>Mon</th>
                                <th>Tue</th>
                                <th>Wed</th>
                                <th>Thu</th>
                                <th>Fri</th>
                                <th>Sat</th>
                                <th>Sun</th>
                            </tr>
                        </thead>
                        <tbody id="planner-body"></tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
    <?php include '../general/Footer.php';?>

    <script src="schedule.js"></script>
</body>
</html>