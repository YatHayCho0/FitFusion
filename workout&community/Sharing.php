
<?php
if (isset($_POST['submit'])) {
    // Get the form data
    $name = $_POST['name'];
    $captionText = $_POST['captionText'];
    $date = $_POST['date'];
    
    // Check if the file was uploaded successfully
    if (isset($_FILES['fileImage']) && $_FILES['fileImage']['error'] == 0) {
        // Retrieve file information
        $file_name = $_FILES['fileImage']['name'];
        $tempname = $_FILES['fileImage']['tmp_name'];
        $folder = '../images/' . $file_name;

        // Check if the file is an image
        $imageFileType = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $valid_extensions = array("jpg", "jpeg", "png", "gif");
        if (in_array($imageFileType, $valid_extensions)) {
            // Move the uploaded file to the destination folder
            if (move_uploaded_file($tempname, $folder)) {
                // Connect to the database
                $localhost = "localhost";
                $user = "root";
                $password = "";
                $database = "fitfusion";
                $connection = new mysqli($localhost, $user, $password, $database);

                // Check connection
                if ($connection->connect_error) {
                    echo "<script>console.log('Connection failed: " . $connection->connect_error . "');</script>";
                    die("Connection failed: " . $connection->connect_error);
                }

                // Prepare and bind the SQL statement
                $test = $connection->prepare("INSERT INTO sharingimage (name, captionText, fileImage, date) VALUES (?, ?, ?, ?)");
                $test->bind_param("ssss", $name, $captionText, $file_name ,$date);

                // Execute the statement
                if ($test->execute()) {
                    echo "<script>console.log('File uploaded and record saved successfully!');</script>";
                } else {
                    echo "<script>console.log('Error saving the record: " . $test->error . "');</script>";
                }

                // Close the statement and connection
                $test->close();
                $connection->close();
            } else {
                echo "<script>console.log('Failed to move the uploaded file.');</script>";
            }
        } else {
            echo "<script>console.log('Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.');</script>";
        }
    } else {
        echo "<script>console.log('File upload failed or no file was selected.');</script>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Posts</title>
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
                <li><a href="Community.php" >Community</a></li>
                <li class="seperator">/</li>
                <li class="current">Posts</li>

            </ul>
        </nav>
    
    </div>

  
   
<div class="all-posts-container">
  
<?php
  include '../general/dbconn.php';

  // Query your database to retrieve all records from sharingimages table
  $sql = "SELECT name, captionText, fileImage,date FROM sharingimage";
  $result = mysqli_query($connection, $sql);

  // Display different elements based on the database result
  if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      // Display the image, name, and caption
      echo "<div style='padding: 25px 25px;' class='post-container'>";
      echo "<span id='displayName'>" . $row["name"] . "</span><br>";

      echo "<span id='displayDate'>" . $row["date"] . "</span><br><br>";

      echo "<img style='width: 100%; height: auto' id='displayImage' src='../images/" . $row["fileImage"] . "'><br>";       
      
      echo "<p style='overflow: hidden; display: -webkit-box; -webkit-line-clamp: 10; line-clamp: 10; -webkit-box-orient: vertical;' id='displayPara'>" . $row["captionText"] . "</p><br>";

      echo "</div>"; // Close the image-container div
      echo "<hr>";
    }
  } else {
    echo "<center>No Posts found</center>";
  }

  // Close the database connection
  mysqli_close($connection);
?>
</div>

<?php include "../general/Footer.php";?>

</body>
</html>

