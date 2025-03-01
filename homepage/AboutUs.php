<?php
    session_start();
    
    if (isset($_SESSION['userid'])) {
        $userid = $_SESSION['userid'];
    } else {
        $userid = null;
    }
    // Homepage does not need userid to able to access. but it will display a button for login if user is not logged in
    // Basically the isset($_SESSION['userid']) checks if userid exits in the $_SESSION
    // Wait technically I don't need this for About Us, eh?
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FITFUSION</title>

    <link rel="stylesheet" href="HOMEPAGE_hero.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="HOMEPAGE_community.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="HOMEPAGE_responsive.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="HOMEPAGE_general.css?v=<?php echo time(); ?>">
</head>

<body>
    <!-- Header-->
    <?php include '../general/Header.php';?>

    <!--Hero, idk why they called this as hero-->
    <section class="hero">
        <div class="overlay-text">ABOUT US</div>
    </section>

    <!--Community, Feedback and FaQ hooray!!!-->
    <section class="community">
        <h2>At FitFusion, we believe fitness should be more than just a routine—it’s a lifestyle that thrives on community, support, and shared goals. Whether you're a beginner or a seasoned athlete, our platform connects you with like-minded individuals who push each other to become stronger, healthier, and more confident.</h2>

        <br><br>

        <h2>We offer a range of workout programs tailored to all fitness levels, engaging challenges to keep you motivated, and a community where you can share your progress, tips, and encouragement. With FitFusion, you’re not just working out—you’re joining a movement that celebrates every victory, big or small.</h2>

        <br><br>

        <h2>Our mission is simple: Build a community that helps you achieve your fitness goals, one workout at a time.</h2>

        <br><br>

        <h2>Join us today, and start your journey towards a healthier you—together, we make progress happen.</h2>
        <!-- I doubt this give marks but so I lower my standard HAHAHA - Dylan -->
    </section>

    <!-- Us Group6 photo (We are group 6 right?) -->
    <section class="team-photos">
        <h2>Meet the Website developers</h2>
        <div class="photos-container">
            <div class="photo">
                <img src="../images/Dylan.jpg" alt="Dylan">
                <p>Dylan Denny TP074879</p>
            </div>
            <div class="photo">
                <img src="../images/Choo.jpg" alt="Choo">
                <p>Choo Yat Hay TP074534</p>
            </div>
            <div class="photo">
                <img src="../images/Choo F.jpg" alt="Choo F">
                <p>Choo Yet Ting TP073584</p>
            </div>
            <div class="photo">
                <img src="../images/CCT.jpg" alt="CCT">
                <p>Chan Cin Tin TP074379</p>
            </div>
            <div class="photo">
                <img src="../images/Eleen.jpg" alt="Eleen">
                <p>Eleen Yang TP073995</p>
            </div>
        </div>
    </section>

    <!--Footer-->
    <?php include '../general/Footer.php';?>
</body>
</html>