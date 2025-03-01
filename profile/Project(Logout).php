<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: 0;
            height: 100%;
            background-image: url('../images/logout.jpg'); /* Replace with your image path */
            background-size: cover;
            background-position: center center; /* Centers the image */
            background-attachment: fixed; /* Keeps the background fixed while scrolling */
            background-repeat: no-repeat;
        }

        a.hover{
            color: blue;
            text-decoration: underline;
        }

        #content{
            margin-top: 18%;
            padding: 20px;
            width: 300px;
            height: 100px;
            background: rgb(250, 235, 215);
            border: 1px solid black;
            text-align: center;
            border-radius: 10%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div id="content">
    <h2 align=center>Successful to Log Out!</h2>
    <p>
        <a href="../homepage/MainPage.php">Main Page</a>
    </p>
    </div>
</body>
</html>