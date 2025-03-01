<?php
include '../general/dbconn.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../general/Navigation.css?v=<?php echo time(); ?>">
    <style>
        #body{
            color: white;
            height: 100%;
            padding: 2%;
            margin-left: 50px;
            margin-top: 30px;
            margin-right: 50px;
            background: rgb(185, 74, 62);
            border: 1px solid black;
            box-shadow: white 0px 4px 10px;
            
        }

        #title{
            font-weight: bold;
        }

        p{
            font-size: 22px;
            margin: 10px;
            padding: 3px;
            color: white;
        }
        
        #top{
            display: center;
            width: 100vw; /* Ensure it covers the entire viewport width */
            height: 130px;
            background-image: url('../images/policy.jpg');
            background-size: cover; /* Stretches the image to cover the div */
            background-attachment: fixed; /* Optional: keeps the image fixed while scrolling */
            color: white;
            margin-left: -10px;
            margin-top: -10px;
            padding: 0;
        }

        body{
            background-color: rgb(32, 66, 84);
            margin: 0px;
            font-family:Arial, sans-serif;
        }
    </style>
    <?php

include '../general/Header.php';

?>
</head>
<body>
    <div id="top">
        <div class="navigation-white">
            <nav class="bar">
                <ul>
                    <li><a href="../homepage/MainPage.php" class="navigation-white">Home</a></li>
                    <li class="seperator">/</li>
                    <li><a href="Project(Profile).php" class="navigation-white">Profile</a></li>
                    <li class="seperator">/</li>
                    <li><a href="#" class="current navigation-white">Policies</a></li>
                </ul>
            </nav>   
        </div>
        <h1 align="center">Policies</h1>
    </div>
    <p>At FitFusion, we value your privacy and are committed to protecting your personal data. This Privacy Policy outlines the types of information we collect from users, how it is used, and the steps we take to safeguard your data. By using FitFusion, you agree to the practices described in this policy.</p>
    <div id="body">
        <table align="center">
            <tr>
            <td id="title">1. Information We Collect <td> 
            </tr>
            <tr></tr>
            <tr>
                <td>We collect the following types of information: </td>
            </tr>
            <tr>
                <td>Personal Information: When you register on FitFusion, we collect information such as your name, email address, and profile picture. You may also provide additional details such as your location and sport preferences. <br><br>

                Sport Activities: FitFusion allows you to record and share your sport activities, including video uploads, performance metrics, and any activity data you provide. <br><br>

                Usage Data: We automatically collect information about how you use FitFusion, including your interactions with the website, pages visited, time spent, and any error reports or logs that help us improve the user experience. <br><br></td>
            </tr>
            <tr>
            <td id="title">2. How We Use Your Information </td>
            </tr>
            <tr></tr>
            <tr>
                <td>FitFusion uses the collected information for the following purposes: <br><br>

                To provide, operate, and maintain the FitFusion platform, allowing you to share and view sport videos and record activities. <br>
                To personalize your experience, including recommending videos, activities, or users based on your interactions and preferences. <br>
                To communicate with you, send updates, and provide customer support. <br>
                To analyze usage trends and monitor the effectiveness of the website. <br>
                To improve our website and develop new features. <br><br></td>
            </tr>
            <tr></tr>
            <tr>
            <td id="title">3. Sharing of Your Information </td>
            </tr>
            <tr>
                <td>We may share your data with: </td>
            </tr>
            <tr>
                <td>Other Users: Content you upload, such as videos and activity data, may be visible to other FitFusion users. You can control certain privacy settings related to your uploads. <br><br>

                Service Providers: We may share information with trusted third-party providers who assist us in running the website, including hosting services, data analytics, and customer support. <br><br>

                Legal Compliance: If required by law or to protect the rights and safety of our users and the platform, we may share information with law enforcement or other authorities. <br><br></td>
            </tr>
            <tr>
            <td id="title">4. Cookies and Tracking Technologies </td>
            </tr>
            <tr></tr>
            <tr>
                <td>FitFusion uses cookies and similar tracking technologies to enhance your experience. These cookies help us remember your preferences, analyze website performance, and provide personalized content. You can adjust your cookie preferences in your browser settings, though disabling cookies may limit your ability to use certain features. <br><br></td>
            </tr>
            <tr>
            <td id="title">5. Data Security </td>
            </tr>
            <tr></tr>
            <tr>
                <td>We implement appropriate technical and organizational measures to safeguard your data from unauthorized access, disclosure, or loss. However, no online platform is completely secure, and we encourage you to protect your account with a strong password and monitor your account activity regularly. <br><br></td>
            </tr>
            <tr>
            <td id="title">6. Your Choices and Rights </td>
            </tr>
            <tr></tr>
            <tr>
                <td>You have the following rights concerning your data: </td>
            </tr>
            <tr>
                <td>Access and Correction: You may access and update your personal information through your account settings. <br><br>

                Deletion: You can request the deletion of your account and associated data by contacting us at [Insert Contact Email]. <br><br>

                Privacy Settings: FitFusion provides privacy controls, allowing you to decide who can view your uploaded content and shared activities. <br><br>
            </td>
            </tr>
            <tr>
            <td id="title">7. Changes to This Privacy Policy </td>
            </tr>
            <tr></tr>
            <tr>
                <td>We may update this Privacy Policy from time to time to reflect changes in our practices or for legal, regulatory, or operational reasons. Any changes will be posted on this page with an updated effective date. <br><br></td>
            </tr>
        </table>
    </div>
</body>
</html>

<?php
include '../general/Footer.php';
?>