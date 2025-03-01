<?php
    session_start();
    
    if (isset($_SESSION['userid'])) {
        $userid = $_SESSION['userid'];
    } else {
        $userid = null;
    }
    // Homepage does not need userid to able to access. but it will display a button for login if user is not logged in
    // Basically the isset($_SESSION['userid']) checks if userid exits in the $_SESSION
?>

<?php
    // session_destroy();
    // THIS LINE OF CODE IS FOR TESTING PURPOSE TO TEST IF MY LOGIN BUTTON WORKS, THAT'S WHY IS COMMENTED
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FITFUSION</title>

    <link rel="stylesheet" href="HOMEPAGE_hero.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="HOMEPAGE_content.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="HOMEPAGE_community.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="HOMEPAGE_responsive.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="HOMEPAGE_general.css?v=<?php echo time(); ?>">
</head>

<body>
    <!-- Header-->
    <?php include '../general/Header.php';?>

    <!--Hero, idk why they called this as hero-->
    <section class="hero">
        <div class="overlay-text">FITFUSION</div>
        <div class="motto">Join, Sweat, and Succeed with Us</div>
        <div id="login-prompt"></div>
    </section>

    <script>
        var isLoggedIn = <?php echo $userid ? 'true' : 'false'; ?>;
        // This line declares a JS var named isLoggedin by using PHP to determine the value from the session var 'userid'

        if (!isLoggedIn) {
            var LOGINBUTTON = document.createElement('button');
            LOGINBUTTON.textContent = 'Your Journey Begins here';
            LOGINBUTTON.onclick = function() {
                window.location.href = '../login/login.php'; // CCT's Login Page
            };

            // Basically the user gets ID from the document which in the section hero is login-prompt, it then append aka add the button
            document.getElementById('login-prompt').appendChild(LOGINBUTTON);
        }
    </script>

    <!--Content-->
    <section class="content">
        <div class="content-block">
            <div class="content-image image1"></div>
            <div class="text-overlay">Challenge & Programs</div>
            <div class="description">
                <p><strong>“Push your limits with curated fitness programs and engaging challenges designed for all levels. From strength training to cardio, each program is crafted to help you hit your goals, whether you're aiming to build muscle, lose weight, or simply stay active. Join a challenge today and see how far you can go.”</strong></p>
                <a href="../challenges/challenges.php">
                    <button>Start Challenging</button>
                </a>
            </div>
        </div>

        <div class="content-block">
            <div class="content-image image2"></div>
            <div class="text-overlay">Calorie Tracker</div>
            <div class="description">
                <p><strong>"Keep track of your nutrition with our easy-to-use calorie tracker. Log your meals, set your daily goals, and monitor your progress over time. Whether you're trying to maintain, gain, or lose weight, our tracker helps you stay accountable and make informed decisions about your diet.”</strong></p>
                <a href="../tracking/Calorie.php">
                    <button>Start Tracking</button>
                </a>
            </div>
        </div>
    </section>

    <!--Community, Feedback and FaQ hooray!!!-->
    <section class="community">
        <h2>There are many others like you in the community!</h2>
        <div class="post-grid">
            <div class="post image1"></div>
            <div class="post image2"></div>
            <div class="post image3"></div>
            <div class="post image4"></div>
        </div>
        <div class="community-join">
            <a href="../workout&community/Workout.php">
                <button>Join the Community</button>
            </a>
        </div>

        <br>

        <!-- Feedback -->
        <div class="feedback">
            <h2>Got a suggestion? Share it to us!</h2>
            <a href="../feedback/feedback.php">
                <button>Feedback</button>
                </a>
        </div>
        
        <!-- About us -->
        <div class="about_us">
            <a href="AboutUs.php">
                <button>About Us</button>
            </a>
        </div>
    </section>

    <!--Footer-->
    <?php include '../general/Footer.php';?>
</body>
</html>