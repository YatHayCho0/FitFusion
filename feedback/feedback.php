<?php
session_start();

include '../general/dbconn.php';
include '../general/Header.php';

$firstname = isset($_SESSION['firstname']) ? $_SESSION['firstname'] : 'None'; // isset()check first and lastname have save or not
$lastname = isset($_SESSION['lastname']) ? $_SESSION['lastname'] : 'None'; 

if (!isset($_SESSION['userid'])) {
    header('Location: ../login/login.php');
    exit();
}

$formSubmitted = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $feedback_emoji = mysqli_real_escape_string($connection, $_POST['emoji']);// Special character conversion string
    $feedback_categories = mysqli_real_escape_string($connection, $_POST['categories']);
    $feedback_text = mysqli_real_escape_string($connection, $_POST['feedback']);
    $rating = mysqli_real_escape_string($connection, $_POST['rating']);

    $stmt = mysqli_prepare($connection, "INSERT INTO feedbacktbl (username, feedback_emoji, feedback_categories, feedback_text, rating) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'ssssi', $username, $feedback_emoji, $feedback_categories, $feedback_text, $rating);// Bind

    // Execute the statement to the database
    if (mysqli_stmt_execute($stmt)) {
        $formSubmitted = true; // Set to true to show success message
        header("Location: feedback.php?success=1");
        exit();
    } else {
        $errorMessage = 'Error: ' . mysqli_error($connection);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($connection);
}

$showAlert = isset($_GET['success']) && $_GET['success'] == '1';

$totalRatings = 0;
$totalReviews = 0;// Total comment
$ratingCounts = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0]; // Record the num of stars for each
$reviews = [];

$query = "SELECT username, feedback_categories, feedback_text, rating, created_at FROM feedbacktbl";
$result = mysqli_query($connection, $query);// Use to fetch the information from database

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) { // Use associative array way to fetch data
        $rating = (int) $row['rating'];
        $totalRatings += $rating; // Add rating
        $totalReviews++; // Add comment
        
        if (isset($ratingCounts[$rating])) {
            $ratingCounts[$rating]++; // Count the num of each star
        }


        // Save comment data into an array
        $reviews[] = [
            'username' => $row['username'],
            'date' => $row['created_at'],
            'rating' => $rating,
            'categories' => $row['feedback_categories'] ? $row['feedback_categories'] : 'None', // If not caategorized,display None
            'text' => $row['feedback_text'] ? $row['feedback_text'] : 'No feedback provided' // If not feedback,display No feedback provided
        ];
    }
}

$averageRating = $totalReviews > 0 ? round($totalRatings / $totalReviews, 1) : 0; // Keep 1 decimal place, if not any comment then is 0

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
    <link rel="stylesheet" href="feedback.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../general/Navigation.css?v=<?php echo time(); ?>">
</head>
<body>
    <header>
        <div class="collage-container">
            <!-- Collage of images -->
            <div class="collage-item">
                <img src="../images/feedback1.jpg" alt="Feedback Image 1">
            </div>
        </div>
    </header>

    <!-- Feedback Form Section -->
    <div class="page-layout">
        <div class="feedback-container">
            <!-- NAVIGATION BAR  -->
            <div class="navigation-black">
                <nav  class="bar">
                    <ul>
                        <li><a href="../homepage/MainPage.php" class="navigation-black">Home</a></li>
                        
                        <li class="seperator">/</li>
                        <li><a href="feedback.php" class="current navigation-black">Feedback</a></li>
                    </ul>
                </nav>
            </div>
            <h1>Your Feedback</h1>
            <p>We would like your feedback to improve our website.</p>

            <!-- Feedback form with POST method -->
            <form action="feedback.php" method="POST" id="feedbackForm">
                <span>Name</span>
                <div class="username">
                    <input type="text" name="username" id="username" value="<?php echo $firstname . ' ' . $lastname; ?>"  required>
                </div>

                <span>What is your opinion of this page?</span>
                <div class="emojis" id="emojiSelection">
                    <img src="../images/icons8-sad-face-48.png" alt="Sad" data-emoji="Sad" onclick="selectEmoji(this)">
                    <img src="../images/icons8-confused-face-48.png" alt="Confused" data-emoji="Confused" onclick="selectEmoji(this)">
                    <img src="../images/icons8-neutral-face-48.png" alt="Neutral" data-emoji="Neutral" onclick="selectEmoji(this)">
                    <img src="../images/icons8-smiling-face-48.png" alt="Happy" data-emoji="Happy" onclick="selectEmoji(this)">
                    <img src="../images/icons8-star-struck-48.png" alt="Very Happy" data-emoji="Very Happy" onclick="selectEmoji(this)">
                </div>

                <span>Please select your feedback category below.</span>
                <div class="category-buttons" id="categorySelection">
                    <button type="button" onclick="toggleCategory(this)" data-category="Website Design">Website Design</button>
                    <button type="button" onclick="toggleCategory(this)" data-category="Content Quality">Content Quality</button>
                    <button type="button" onclick="toggleCategory(this)" data-category="User Experience">User Experience</button>
                    <button type="button" onclick="toggleCategory(this)" data-category="Navigation">Navigation</button>
                    <button type="button" onclick="toggleCategory(this)" data-category="Other">Other</button>
                </div>

                <textarea id="feedbackText" name="feedback" placeholder="Please leave your feedback below:"></textarea>

                <span>Rate your experience:</span>
                <div class="star-rating" id="starRating">
                    <span class="star" data-value="1">&#9734;</span>
                    <span class="star" data-value="2">&#9734;</span>
                    <span class="star" data-value="3">&#9734;</span>
                    <span class="star" data-value="4">&#9734;</span>
                    <span class="star" data-value="5">&#9734;</span>
                </div>
                <input type="hidden" id="ratingInput" name="rating"> <!-- Hidden save information to the server(data-value) -->

                <input type="hidden" id="emojiInput" name="emoji"> <!-- Hidden save information to server(data-emoji) -->
                <input type="hidden" id="categoryInput" name="categories"> <!-- Hidden save information to server(data-category",") -->

                <button type="submit" class="submit-button">Send</button>
            </form>
        </div>
        <!-- Right hand side -->
        <div class="reviews-container">
            <h2>Our Reviews</h2>
            <p>Of course we utilize our own service to constantly gather feedback</p>

            <!-- Rating section -->
            <div class="rating-summary">
                <h3><?php echo $averageRating; ?> Out of 5 Stars</h3>
                <div class="stars">
                    <?php
                    // Show stars based on ratings
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= floor($averageRating)) {// Floor= down get integer
                            echo '★'; 
                        } else {
                            echo '☆'; 
                        }
                    }
                    ?>
                </div>

                <!-- Comment distribution bar -->
                <?php foreach ($ratingCounts as $stars => $count): ?> <!-- ratingcounts is associative array -->
                    <div class="rating-bar">
                        <span><?php echo $stars; ?> Stars: <?php echo $count; ?></span>
                        <div class="bar-background">
                            <div class="bar-fill" style="width: <?php echo ($totalReviews > 0 ? ($count / $totalReviews) * 100 : 0); ?>%;"></div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>

            <!-- Customer comment -->
            <div class="customer-reviews">
                <?php foreach ($reviews as $review): ?> <!-- each $review is current comment($reviews is array) -->
                    <div class="review-card">
                        <h4><?php echo $review['username']; ?> - <?php echo date('F j, Y', strtotime($review['date'])); ?></h4>
                        <div class="stars">
                            <?php
                            // Show stars based on customer
                            for ($i = 1; $i <= 5; $i++) {
                                echo $i <= $review['rating'] ? '★' : '☆';
                            }
                            ?>
                        </div>
                        <p><strong>Categories:</strong> <?php echo $review['categories']; ?></p>
                        <p><?php echo $review['text']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <?php include '../general/Footer.php';?>

    <script src="feedback.js?v=<?php echo time(); ?>"></script>
    <script>
        // Show success alert if the form was submitted successfully
        <?php if ($showAlert): ?>
            alert('Feedback added successfully!');
            // After showing the alert, remove the query string to avoid showing the alert on refresh
            if (window.history.replaceState) {
                const url = new URL(window.location);
                url.searchParams.delete('success'); // Remove the 'success' parameter
                window.history.replaceState(null, '', url); // Update the URL without refreshing(first is state object, second is tittle, third is url after update)
            }
        <?php endif; ?>
    </script>
</body>
</html>