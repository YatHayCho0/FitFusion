<?php
session_start();

include '../general/dbconn.php';  // Include database connection file

$loginError = "";  // Initialize error message

if (isset($_POST['btnLogin'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        // Query the database to check if credentials match
        $query = "SELECT * FROM usertable WHERE email='$email' AND password='$password' ";
        $results = mysqli_query($connection, $query);

        if (mysqli_num_rows($results) == 1) {
            // Successful login, create session
            while ($row = mysqli_fetch_assoc($results)) {
                $_SESSION['userid'] = $row['userid'];
                $_SESSION['firstname'] = $row['firstname'];
                $_SESSION['lastname'] = $row['lastname'];

                // Redirect to the homepage
                header("Location: ../homepage/Mainpage.php");
                exit(); // Ensure to stop further execution after redirection
            }
        } else {
            // If email or password is incorrect
            $loginError = "Wrong email or password";
        }
    } else {
        $loginError = "Email and Password cannot be empty"; // If fields are empty
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="login.css?v=<?php echo time(); ?>"> <!-- Link to CSS file with cache busting -->
    <script defer src="login.js"></script> <!-- Link to JS file -->
</head>
<body>
    <div class="container">
        <!-- Left side advertisement images -->
        <div class="ad-section">
            <img src="../images/ad1.JPG" alt="Ad 1" class="ad-img img1">
            <img src="../images/ad2.JPG" alt="Ad 2" class="ad-img img2">
            <img src="../images/ad3.JPG" alt="Ad 3" class="ad-img img3">
        </div>

        <!-- Right side login form -->
        <div class="login-section">
            <!-- Logo -->
            <img src="../images/logo.png" alt="Logo" class="logo">

            <!-- Login form -->
            <form action="login.php" method="post">
                <input type="text" id="email" name="email" placeholder="Email" class="input-field" value="<?php echo isset($email) ? $email : ''; ?>">
                <div class="password-container">
                    <input type="password" id="password" name="password" placeholder="Password" class="input-field">
                    <span id="toggle-password" class="toggle-password">👁️</span> <!-- Toggle password visibility -->
                </div>

                <!-- Display login error message -->
                <p name="login-error" class="error-message"><?php echo $loginError; ?></p>

                <button type="submit" class="login-button" name="btnLogin">Login</button>
                <br>
                <a href="../register/Project(Register).php" class="register-link">Click Here To Register</a> <!-- Registration link -->
            </form>
        </div>
    </div>
</body>
</html>