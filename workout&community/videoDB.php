<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Workout</title>
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
                <li><a href="Workout.php" >Workout</a></li>
                <li class="seperator">/</li>
                <li class="current">Workout Tutorial</li>

            </ul>
        </nav>
    
    </div>
  
<?php
  $id = $_GET['id'];


  include '../general/dbconn.php';

  // Query your database based on the selected ID
  $sql = "SELECT link, text_video FROM liveworkouts WHERE id = '$id'";
  $result = mysqli_query($connection, $sql);

  // Display different elements based on the database result
  if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      // Display the video link and text inside the video-container div
      echo "<div id='video-container'>";
      echo '<iframe width="80%" height="400" src="https://www.youtube.com/embed/' . $row["link"] . '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>';      
      echo "<p>" . $row["text_video"] . "</p>";
      echo "</div>"; // Close the video-container div
      echo "<hr>";
    }
  } else {
    echo "No data found for ID $id";
  }

  // Close the database connection
  mysqli_close($connection);
?>
<?php include "../general/Footer.php";?>
</body>
</html>

