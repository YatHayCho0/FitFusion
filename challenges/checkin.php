<?php
include '../general/dbconn.php'; // Include database connection file
include '../general/Header.php'; // Include header file
session_start();
$userid = $_SESSION['userid']; // Assume user ID is stored in session

// Check and get challenge ID from POST or GET request
if (!isset($_POST['challengeid']) && !isset($_GET['challengeid'])) {
    die('Error: Challenge ID is missing.');
}

$challengeId = $_POST['challengeid'] ?? $_GET['challengeid'];

if (empty($challengeId)) {
    die('Error: Challenge ID is empty.');
}

// If starting a new challenge, do not retrieve challenge details immediately
if (isset($_POST['btnstart'])) {
    // Logic to start a new challenge
    $newchallengeId = $_POST['challengeid'];
    $startDate = date('Y-m-d');
    $endDate = date('Y-m-d', strtotime('+6 days')); // Set end date 7 days after start date
    $sql ="INSERT INTO userchallenges (userid, challengeid, progress, startDate, endDate) 
           VALUES ('$userid', '$newchallengeId', 0, '$startDate', '$endDate')";
    mysqli_query($connection, $sql); // Insert challenge data into the database
    header("Location: checkin.php?challengeid=$newchallengeId"); // Redirect to check-in page for the new challenge
    exit;
}

// Retrieve challenge details from the database
$sql_challenge = "SELECT c.challengeid, c.challengeName, c.description, c.difficulty, c.img, uc.progress, uc.startDate, uc.endDate
    FROM userchallenges uc
    JOIN challengetable c ON uc.challengeid = c.challengeid
    WHERE uc.challengeid = $challengeId AND uc.userid = '$userid'";
$result = mysqli_query($connection, $sql_challenge);
$challenge = mysqli_fetch_assoc($result);

if (!$challenge) {
    die('Error: Challenge not found.');
}

$challenge['img'] = 'data:image/jpeg;base64,' . base64_encode($challenge['img']); // Assuming the image is in JPEG format

// Get suggested challenges with the same difficulty level
$sql_suggested = "SELECT c.challengeid, c.challengeName, c.description, c.difficulty, c.img
                  FROM challengetable c 
                  WHERE c.difficulty = '{$challenge['difficulty']}' 
                  AND c.challengeid != $challengeId 
                  AND NOT EXISTS (
                      SELECT 1 FROM userchallenges uc 
                      WHERE uc.challengeid = c.challengeid 
                      AND uc.userid = '$userid'
                  )";
$suggestedResult = mysqli_query($connection, $sql_suggested);

// Get ongoing challenges for the user
$sql_ongoing = "SELECT c.challengeid, c.challengeName, c.description, c.difficulty, c.img
                FROM userchallenges uc 
                JOIN challengetable c ON uc.challengeid = c.challengeid 
                WHERE uc.userid = '$userid' AND c.challengeid != $challengeId AND uc.progress < 7";
$ongoingResult = mysqli_query($connection, $sql_ongoing);

// Initialize arrays for suggested and ongoing challenges
$suggestedChallenges = [];
$ongoingChallenges = [];

// Process suggested challenges and convert BLOB data to Base64
while ($row = mysqli_fetch_assoc($suggestedResult)) {
    $row['img'] = 'data:image/jpeg;base64,' . base64_encode($row['img']); // Convert image to Base64
    $suggestedChallenges[] = $row; // Add suggested challenge to the array
}

// Process ongoing challenges and convert BLOB data to Base64
while ($row = mysqli_fetch_assoc($ongoingResult)) {
    $row['img'] = 'data:image/jpeg;base64,' . base64_encode($row['img']); // Convert image to Base64
    $ongoingChallenges[] = $row; // Add ongoing challenge to the array
}

// Calculate check-in date range for the challenge
$startDate = new DateTime($challenge['startDate']);
$dateInterval = DateInterval::createFromDateString('1 day');
$datePeriod = new DatePeriod($startDate, $dateInterval, 7); // Create a 7-day period

// Handle form submission logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['checkInDay'])) {
        // Logic to update check-in progress
        $newProgress = $_POST['checkInDay'];
        $sql_update_progress = "UPDATE userchallenges SET progress = '$newProgress' WHERE challengeid = '$challengeId' AND userid = '$userid'";
        mysqli_query($connection, $sql_update_progress); // Update progress in the database
        header("Location: checkin.php?challengeid=$challengeId"); // Redirect to the same check-in page
        exit;
    }

    if (isset($_POST['btncheckIn'])) {
        // Switch to check-in page for another ongoing challenge
        $newchallengeId = $_POST['challengeid'];
        header("Location: checkin.php?challengeid=$newchallengeId"); // Redirect to the check-in page of the new challenge
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check In</title>
    <link rel="stylesheet" href="checkin.css?v=<?php echo time(); ?>"> <!-- Force reload of CSS -->
    <link rel="stylesheet" href="../general/Navigation.css?v=<?php echo time(); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>

<!-- NAVIGATION BAR  -->
<div class="navigation-white">
    <nav class="bar">
        <ul>
            <li><a href="../homepage/MainPage.php" class="navigation-white">Home</a></li>
            <li class="seperator">/</li>
            <li><a href="challenges.php" class="navigation-white">Challenges</a></li>
            <li class="seperator">/</li>
            <li><a href="checkin.php" class="current navigation-white">Check In</a></li>
        </ul>
    </nav>
</div>

<!-- Top Section: Challenge Details -->
<section class="challenge-details">
    <div class="details" style="background-image: url('<?= htmlspecialchars($challenge['img']); ?>');">
        <h2><?= htmlspecialchars($challenge['challengeName']); ?></h2>
        <p><?= htmlspecialchars($challenge['description']); ?></p>
        <p>Progress: <?= htmlspecialchars($challenge['progress']); ?>/7</p>
        <p>Difficulty: <?= htmlspecialchars($challenge['difficulty']); ?></p>
        <p>Start Date: <?= htmlspecialchars($challenge['startDate']); ?></p>
        <p>End Date: <?= htmlspecialchars($challenge['endDate']); ?></p>
    </div>
</section>

<!-- Middle Section: Check-In Days -->
<section class="check-in-grid">
    <h3>Check In</h3>
    <form method="POST" action="checkin.php?challengeid=<?= htmlspecialchars($challengeId); ?>">
        <div class="days-grid">
            <?php
            $dayCount = 1;
            foreach ($datePeriod as $date) :
                if ($dayCount > 7) break; // Limit to 7 days
                $dateString = $date->format('d/m/Y');
            ?>
                <div class="day <?= ($challenge['progress'] >= $dayCount) ? 'checked-day' : (($challenge['progress'] == $dayCount - 1) ? 'highlight-day' : ''); ?>">
                    <input type="radio" id="day<?= $dayCount ?>" name="checkInDay" value="<?= $dayCount ?>" <?= ($challenge['progress'] >= $dayCount) ? 'disabled' : ''; ?>>
                    <label for="day<?= $dayCount ?>">Day <?= $dayCount ?></label>
                </div>
            <?php
                $dayCount++;
            endforeach;
            ?>
        </div>
        <div class="submit-button">
            <button type="submit" class="submit-check-in">Submit Check In</button>
        </div>
    </form>
</section>

<!-- Bottom Section: Suggested Challenges and Ongoing Challenges -->
<section class="suggested-challenges">
    <h3>You May Also Like</h3>
    <div class="suggestions">
        <?php foreach ($suggestedChallenges as $suggested): ?>
            <div class="suggested-challenge challenge-<?= htmlspecialchars($suggested['difficulty']); ?>" 
            style="background-image: url('<?= $suggested['img']; ?>');">
                <p><?= htmlspecialchars($suggested['challengeName']); ?></p>
                <form method="POST" action="checkin.php">
                    <input type="hidden" name="challengeid" value="<?= htmlspecialchars($suggested['challengeid']); ?>">
                    <button type="submit" name="btnstart" class="start-challenge">Start</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="ongoing-challenges">
    <h3>Ongoing Challenges</h3>
    <div class="ongoing-list">
        <?php foreach ($ongoingChallenges as $ongoing): ?>
            <div class="ongoing-challenge challenge-<?= htmlspecialchars($ongoing['difficulty']); ?>"
            style="background-image: url('<?= $ongoing['img']; ?>');">
                <p><?= htmlspecialchars($ongoing['challengeName']); ?></p>
                <form method="POST" action="checkin.php">
                    <input type="hidden" name="challengeid" value="<?= htmlspecialchars($ongoing['challengeid']); ?>">
                    <button type="submit" name="btncheckIn" class="check-in-challenge">Check In</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</section>

</body>
</html>

<?php
include '../general/Footer.php'; // Include footer file
?>