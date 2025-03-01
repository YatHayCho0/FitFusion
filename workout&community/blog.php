<?php
include '../general/dbconn.php';
$id = $_GET['id'];
$sql = "SELECT titleText, image, contentText FROM blogs WHERE id = ?";
$stmt = mysqli_prepare($connection, $sql);
mysqli_stmt_bind_param($stmt, "i", $id); // Bind the ID as an integer
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Fetch data if the result is found
$row = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $row ? htmlspecialchars($row['titleText']) : 'No Data Found'; ?></title>
  <link rel="stylesheet" href="../general/Navigation.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  
</head>
<Style>
    
</Style>
<body>

<?php include "../general/Header.php";?>

<div>
  <nav class="bar">
    <ul>
      <li><a href="../homepage/MainPage.php">Home</a></li>           
      <li class="seperator">/</li>
      <li><a href="Community.php">Community</a></li>
      <li class="seperator">/</li>
      <li class="current"><?php echo $row ? htmlspecialchars($row['titleText']) : 'No Data Found'; ?></li>
    </ul>
  </nav>
</div>

<?php
  if ($row) {
    // Directly use the contentText since it's already in TEXT format
    $contentText = $row["contentText"];

    // Encode the image as base64
    $encodedImage = base64_encode($row['image']);

    echo "<div id='blog-container'>";
    echo "<h2>" . htmlspecialchars($row["titleText"]) . "</h2>";

    // Display the image from the BLOB field
    echo '<img src="data:image/jpeg;base64,' . $encodedImage . '" alt="Blog Image" width="80%" height="auto">';

    // Display the contentText safely
    echo "<p>" . nl2br(htmlspecialchars($contentText)) . "</p>";
    echo "</div>";
    echo "<hr>";
  } else {
    echo "No data found for ID $id";
  }

  // Close the database connection
  mysqli_close($connection);
?>

</div>

<?php include "../general/Footer.php";?>
</body>
</html>
