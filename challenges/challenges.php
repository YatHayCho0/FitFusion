<?php
session_start();
include '../general/dbconn.php'; // Database connection
include '../general/Header.php'; // Include header

if (!isset($_SESSION['userid'])) {
    header('Location: ../login/login.php');
    exit();
}

$userid = $_SESSION['userid'];

// Query for ongoing challenges
$sql_ongoing = "
    SELECT c.challengeid, c.challengeName, c.description, c.difficulty, c.img, uc.progress, uc.startDate, uc.endDate
    FROM userchallenges uc
    JOIN challengetable c ON uc.challengeid = c.challengeid
    WHERE uc.userid = '$userid' AND uc.progress < 7"; // Progress less than 7 indicates the challenge is ongoing
$result_ongoing = mysqli_query($connection, $sql_ongoing);

// Query for available challenges
$sql_available = "
    SELECT c.challengeid, c.challengeName, c.description, c.difficulty, c.img
    FROM challengetable c
    WHERE NOT EXISTS (
        SELECT 1 FROM userchallenges uc WHERE uc.challengeid = c.challengeid AND uc.userid = '$userid')"; // Select challenges the user hasn't started yet
$result_available = mysqli_query($connection, $sql_available);

// Initialize arrays for challenges
$ongoingChallenges = [];
$availableChallenges = [];

// Fetch ongoing challenges and encode images as base64
while ($row = mysqli_fetch_assoc($result_ongoing)) {
    // Convert BLOB data to Base64 encoding
    $row['img'] = 'data:image/jpeg;base64,' . base64_encode($row['img']); // Assuming the image is JPEG format
    $ongoingChallenges[] = $row;
}

// Fetch available challenges and encode images as base64
while ($row = mysqli_fetch_assoc($result_available)) {
    // Convert BLOB data to Base64 encoding
    $row['img'] = 'data:image/jpeg;base64,' . base64_encode($row['img']); // Assuming the image is JPEG format
    $availableChallenges[] = $row;
}

// Handle requests to start or leave a challenge
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $challengeid = mysqli_real_escape_string($connection, $_POST['challengeid']);
    $action = mysqli_real_escape_string($connection, $_POST['action']);
    
    if ($action == 'confirmLeave') {
        // User leaves the challenge
        $sql = "DELETE FROM userchallenges WHERE challengeid='$challengeid' AND userid='$userid'";
    } else if ($action == 'start') {
        // User starts a new challenge
        $startDate = date('Y-m-d'); // Current date as start date
        $endDate = date('Y-m-d', strtotime('+6 days')); // End date is 7 days later, adjust as needed
        $sql = "
            INSERT INTO userchallenges (userid, challengeid, progress, startDate, endDate)
            VALUES ('$userid', '$challengeid', 0, '$startDate', '$endDate')"; // Initial progress is 0
    }

    // Execute query and handle success or error
    if (mysqli_query($connection, $sql)) {
        header("Location: challenges.php?status=success");
    } else {
        header("Location: challenges.php?status=error&message=" . mysqli_error($connection));
    }
    exit;
}

// Query for completed challenges
$sql_completed = "
    SELECT c.challengeid, c.challengeName, c.description, c.difficulty, c.img
    FROM userchallenges uc
    JOIN challengetable c ON uc.challengeid = c.challengeid
    WHERE uc.userid = '$userid' AND uc.progress = 7"; // Progress equals 7 indicates the challenge is completed
$result_completed = mysqli_query($connection, $sql_completed);

$completedChallenges = [];
while ($row = mysqli_fetch_assoc($result_completed)) {
    $row['img'] = 'data:image/jpeg;base64,' . base64_encode($row['img']); // Assuming JPEG
    $completedChallenges[] = $row;
}

// Close database connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercise Challenges</title>
    <link rel="stylesheet" href="challenges.css?v=<?php echo time(); ?>"> <!-- Prevent caching -->
    <script defer src="challenges.js?v=<?php echo time(); ?>"></script> <!-- Defer script loading -->
    <link rel="stylesheet" href="../general/Navigation.css?v=<?php echo time(); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    
</head>
<body>
    <header class="topic">
        <h1>Exercise Challenges</h1>
        <div id="trophy-icon">🏆</div> <!-- Trophy icon -->
    </header>

    <!-- Sidebar for Completed Challenges -->
    <div id="completedChallengesSidebar" class="sidebar">
        <div class="sidebar-header">
            <h2 class="sidebar-header">Completed Challenges</h2>
            <span id="closeSidebar" class="close-sidebar">&times;</span> <!-- Close button for the sidebar -->
        </div>
        <div class="completed-challenges">
            <?php foreach ($completedChallenges as $challenge): ?>
                <div class="completed-challenge"
                    style="background-image: url('<?= $challenge['img']; ?>');"> <!-- Display challenge image -->
                    <p><?= htmlspecialchars($challenge['challengeName']); ?></p>
                    <p>Difficulty: <?= htmlspecialchars($challenge['difficulty']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Navigation bar -->
    <div class="navigation-black">
        <nav class="bar">
            <ul>
                <li><a href="../homepage/MainPage.php" class="navigation-black">Home</a></li>
                <li class="seperator">/</li>
                <li><a href="challenges.php" class="current navigation-black">Challenges</a></li>
            </ul>
        </nav>
    </div>

    <section class="challenges">
        <h2>Ongoing Challenges</h2>
        <div class="ongoing-challenges">
            <?php foreach ($ongoingChallenges as $challenge): ?>
                <div class="challenge challenge-<?= htmlspecialchars($challenge['difficulty']); ?> "
                    style="background-image: url('<?= $challenge['img']; ?>');"
                    data-description="<?= htmlspecialchars($challenge['description']); ?>"
                    data-start-date="<?= htmlspecialchars($challenge['startDate']); ?>"
                    data-end-date="<?= htmlspecialchars($challenge['endDate']); ?>"
                    data-challenge-id="<?= htmlspecialchars($challenge['challengeid']); ?>">

                    <div class="progress-circle">
                        <div class="progress-bar" style="width: <?= htmlspecialchars($challenge['progress'])/7*100; ?>%;"></div> <!-- Display progress as a percentage -->
                    </div>
                    <p><?= htmlspecialchars($challenge['challengeName']); ?></p>
                    <div class="buttons-container"> <!-- New button container -->
                        <button type="submit" class="leave" data-challenge-id="<?= htmlspecialchars($challenge['challengeid']); ?>">Leave</button> <!-- Leave button -->
                        <form method="POST" action="checkin.php" style="display:inline;">
                            <input type="hidden" name="challengeid" value="<?= htmlspecialchars($challenge['challengeid']); ?>">
                            <button type="submit" class="check-in">Check In</button> <!-- Check-in button -->
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <h2>Available Challenges</h2>
        <div class="filter">
            <label for="difficulty">Filter by Difficulty:</label>
            <select id="difficulty">
                <option value="all">All</option>
                <option value="lightly">Lightly</option>
                <option value="moderately">Moderately</option>
                <option value="highly">Highly</option>
            </select>
        </div>
        <div class="available-challenges">
            <?php foreach ($availableChallenges as $challenge): ?>
                <div class="challenge challenge-<?= htmlspecialchars($challenge['difficulty']); ?>"
                    style="background-image: url('<?= $challenge['img']; ?>');"
                    data-description="<?= htmlspecialchars($challenge['description']); ?>"
                    data-challenge-id="<?= htmlspecialchars($challenge['challengeid']); ?>">
                    <p><?= htmlspecialchars($challenge['challengeName']); ?></p>
                    <div class="button-container"> <!-- New button container -->
                        <form method="POST" action="challenges.php">
                            <input type="hidden" name="challengeid" value="<?= htmlspecialchars($challenge['challengeid']); ?>">
                            <input type="hidden" name="action" value="start">
                            <button type="submit" class="start" name="btnStart">Start</button> <!-- Start button -->
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Confirmation modal for leaving a challenge -->
    <div id="leaveModal" class="modal">
        <div class="modal-content">
            <span id="closeModal" class="close">&times;</span> <!-- Close button for modal -->
            <h2 id="challengeName"></h2>
            
            <p id="challengeDescription"></p>
            <p id="challengeDifficulty"></p>
            <p id="challengeStartDate"></p>
            <p id="challengeEndDate"></p>
            <form method="POST" action="challenges.php">
                <input type="hidden" name="challengeid" id="modalChallengeId">
                <input type="hidden" name="action" value="confirmLeave">
                <button type="submit" class="confirmLeave">Confirm Leave</button> <!-- Confirm leave button -->
            </form>
            
        </div>
    </div>

</body>
</html>

<?php
include '../general/Footer.php'; // Include footer
?>