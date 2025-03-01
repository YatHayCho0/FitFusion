<header class="h-header">
    <!-- Preconnect to Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">    

    <style>
        .h-header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background-color: #333;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0px;
            padding-top: 20px;
            padding-bottom: 20px;
            width: 100%;
        }
    
        .h-logo {
            font-size: 24px;
            padding-left: 20px;
            font-weight: bold;
            font-style: italic;
        }

        .h-nav-and-icon {
            padding-right: 20px;
            display: flex;
            align-items: center;
        }

        .h-navigation ul {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
        }

        .h-navigation ul li {
            margin-left: 20px;
        }

        .h-navigation ul li a {
            font-family: "Montserrat" , sans-serif;
            color: white;
            text-decoration: none;
            font-size: 18px;
            display: block;
            position: relative;
            padding: 0.2em 0;
        }

        .h-navigation ul li a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 0.1em;
            background-color: white;
            opacity: 0;
            transition: opacity 300ms, transform 300ms;
        }

        .h-navigation ul li a:hover::after,
        .h-navigation ul li a:focus::after {
            opacity: 1;
            transform: translate3d(0, 0.2em, 0);
        }

        /* https://css-irl.info/animating-underlines/ - ORIGINAL ANIMATION I LEARNT FROM */

        .h-user-icon {
            background-image: url('../images/User_Icon.png');
            width: 40px;
            height: 40px;
            background-size: cover;
            border-radius: 50%;
            margin-left: 20px;
        }

        @media (max-width: 1024px){
        .h-header {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .h-navigation ul{
            flex-direction: row;
            justify-content: center;
            margin-top: 10px;
        }
        }

        /* Better view for Ipad Pro with this responsive version Header*/
    </style>



    <div class="h-logo">FITFUSION</div>
    
    <div class="h-nav-and-icon">
        <nav class="h-navigation">
            <ul>
                <!-- WHEN COMPILE MAKE SURE THE FILE FORMAT IS CORRECT -->
                <li><a href="../homepage/MainPage.php">Home</a></li>
                <li><a href="../tracking/Calorie.php">Tracking</a></li>
                <li><a href="../workout&community/Workout.php">Workout</a></li>
                <li><a href="../challenges/challenges.php">Challenge</a></li>
                <li><a href="../schedule/schedule.php">Schedule</a></li>
                <li><a href="../workout&community/Community.php">Community</a></li>
                <li><a href="../feedback/feedback.php">Feedback</a></li>
            </ul>
        </nav>
        <a href="../profile/Project(Profile).php">
            <div class="h-user-icon"></div>
        </a>
    </div>
</header>