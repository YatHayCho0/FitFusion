<?php
include '../general/dbconn.php';
session_start();

if (!isset($_SESSION['userid'])) {
    header('Location: ../login/login.php');
    exit();
}

$userid = $_SESSION['userid'];

if (isset($_POST['InputADD'])) {
    $weight = $_POST['UserInput']; // Get the user input
    $date = date('Y-m-d H:i:s'); // Get the current date

    // Check if value is negative, what else
    if ($weight < 0 || $weight > 500) {
        echo "<script>alert('The value you tried to insert is invalid. Please try again')</script>";
        echo "<script>window.location.href = 'Weight.php';</script>";
        // Alert the error, then refresh the page. I would do header('Location: Weight.php') but that just refresh the thing immediately the echo still works but is just doesn't display
        exit();
    } else {
        // Insert the data into the table
        $query = "INSERT INTO weighttable (userid, weight, date) VALUES ('$userid', '$weight', '$date')";

        if (mysqli_query($connection, $query)) {
            header('Location: Weight.php'); // Redirect back to refresh the table
            exit();
        } else {
            echo "Error: " . mysqli_error($connection);
        }

        mysqli_close($connection); // Close the database connection
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FITFUSION</title>
    <link rel="stylesheet" href="TRACKING_form.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="TRACKING_table.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="TRACKING_responsive.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="TRACKING_general.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../general/Navigation.css?v=<?php echo time(); ?>">
</head>
<body>
    <!--Header-->
    <?php include '../general/Header.php';?>
    
    <div class="navigation-black">
        <nav class="bar">
            <ul>
                <li><a href="../homepage/MainPage.php" class="navigation-black">Home</a></li>
                <li class="seperator">/</li>
                <li><a href="../tracking/Calorie.php" class="current navigation-black">Tracking</a></li>
            </ul>
        </nav>
    </div>
    
    <section class="container">
        <div class="tracking-buttons">
            <h2>Tracker</h2>
            <div class = "button-wraper">
                <a href="Calorie.php" class="tracking-button"><strong>Calorie</strong></a>
                <a href="Weight.php" class="tracking-button"><strong>Weight</strong></a>
            </div>
        </div>

        <div class="tracking-input">
            <h2>Weight Tracker</h2>
            <form action="" method="POST">
                <label><strong>Weight:</strong></label>
                <input type="number" id="Input" name="UserInput" required>
                <button type="submit" name="InputADD">Submit</button>
            </form>
        </div>

        <div class="tracking-display">
            <h2>Recent Weight Entries</h2>
            <table>
                <thead>
                    <tr>
                        <th>Date & Time</th>
                        <th>Weight (kg)</th>
                    </tr>
                </thead>
                <tbody>
                    <!--Uploads to the database-->
                    <?php
                    include '../general/dbconn.php';

                    $userid = $_SESSION['userid'];
                    $query = "SELECT weight, date FROM weighttable WHERE userid = '$userid' ORDER BY date DESC LIMIT 10";
                    $result = mysqli_query($connection, $query);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['date'] . "</td>";
                            echo "<td>" . $row['weight'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='2'>No entries found.</td></tr>";
                    }

                    mysqli_close($connection);
                    ?>
                </tbody>
            </table>
        </div>
    </section>
    
    <!--Footer-->
    <?php include '../general/Footer.php';?>
</body>
</html>