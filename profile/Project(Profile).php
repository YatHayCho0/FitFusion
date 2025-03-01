<?php
session_start();
include '../general/dbconn.php';
include '../general/Header.php';

if (!isset($_SESSION['userid'])) {
    header('Location: ../login/login.php');
    exit();
}

if(isset($_SESSION['userid'])) {
    $id = $_SESSION['userid'];
} else {
    die('User ID not found in URL.');
}

$query = "SELECT * FROM usertable WHERE userid = '$id'";
$results = mysqli_query($connection, $query);
$userData = mysqli_fetch_assoc($results);

$sql = "SELECT goalsname FROM goals WHERE userid = ?";  // Fetch goals for logged-in user
$stmt = $connection->prepare($sql);
$stmt->bind_param('i', $id);  // Assuming $userid contains the logged-in user's ID
$stmt->execute();
$result = $stmt->get_result();

$checksql = "SELECT * FROM userchallenges WHERE userid = ?";  // Fetch goals for logged-in user
$stmt = $connection->prepare($checksql);
$stmt->bind_param('i', $id);  // Assuming $userid contains the logged-in user's ID
$stmt->execute();
$checkresult = $stmt->get_result();

if(isset($_POST['btnSave'])){
    $fname = $_POST['txtFName'];
    $lname = $_POST['txtLName'];
    $number = $_POST['txtNumber'];
    $email = $_POST['txtEmail'];
    $gender = $_POST['txtGender'];
    $country = $_POST['txtCountry'];

    $updateQuery = "UPDATE usertable SET firstname = '$fname', lastname = '$lname', number='$number', email = '$email', gender = '$gender', country = '$country' WHERE userid = '$id'";
    if (mysqli_query($connection, $updateQuery)) {
        // Refresh the user data after saving
        $results = mysqli_query($connection, $query);
        $userData = mysqli_fetch_assoc($results);
        echo "<script>alert('Updated successfully!');window.location.href = '".$_SERVER['PHP_SELF']."';</script>";
    } else {
        echo "<p style='color: white; margin-left: 20px;>Error updating database: </p>" . mysqli_error($connection);
    }
}

if(isset($_POST['btnReset'])){
    $old = $_POST['oldPassword'];
    $new = $_POST['newPassword'];
    $confirm = $_POST['confirmPassword'];

    $checkQuery = "SELECT password FROM usertable WHERE userid = '$id'";
    $result = mysqli_query($connection, $checkQuery);

    if($result){
        $row = mysqli_fetch_assoc($result);
        $oldpassword = $row['password'];
        
        if($old === $oldpassword){
            if($new === $confirm){
                $resetQuery = "UPDATE usertable SET password = '$new' WHERE userid = '$id'";
                if(mysqli_query($connection, $resetQuery)){
                    $results = mysqli_query($connection, $query);
                    $userData = mysqli_fetch_assoc($results);
                    echo "<script>alert('Password changed successfully!');window.location.href = '".$_SERVER['PHP_SELF']."';</script>";
                }else{
                    echo "<p style='color: white; margin-left: 20px;'>Error updating database: </p>" . mysqli_error($connection);
                }
            }else{
                echo "<script>alert('New passwords do not match. Please try again.');window.location.href = '".$_SERVER['PHP_SELF']."'</script>";
            }
        }else{
            echo "<script>alert('Current password is incorrect. Please try again.');window.location.href = '".$_SERVER['PHP_SELF']."'</script>";
        }
    }
}

if(isset($_POST['btnGoals'])){
    $goals = $_POST['txtGoals'];

    if($goals != NULL){
        $stmt = $connection->prepare("INSERT INTO goals(userid, goalsname)
            VALUES(?, ?)");
        $stmt->bind_param("is", $id, $goals); 
        if ($stmt->execute()) {
            $results = mysqli_query($connection, $query);
            $userData = mysqli_fetch_assoc($results);
            echo "<script>alert('Recording successfully!');window.location.href = '".$_SERVER['PHP_SELF']."';</script>"; 
        } else {
            echo "<p style='color: white; margin-left: 20px;'>('Error to record. Please try again.')</p>";
        }
    }else{
        echo "<script>alert('Please enter your goals.');window.location.href = '".$_SERVER['PHP_SELF']."'</script>";
    }
}

if(isset($_POST['btnEditImg'])){
    if(isset($_FILES['pic']) && $_FILES['pic']['error'] == 0){
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $fileInfo = pathinfo($_FILES['pic']['name']);
        $fileExt = strtolower($fileInfo['extension']);

        if(in_array($fileExt, $allowed)){
            $imgData = file_get_contents($_FILES['pic']['tmp_name']);

            $escapedImage = mysqli_real_escape_string($connection, $imgData);

            $updateImageQuery = "UPDATE usertable SET pic = '$escapedImage' WHERE userid = '$id'";
            if(mysqli_query($connection, $updateImageQuery)){
                $results = mysqli_query($connection, $query);
                $userData = mysqli_fetch_assoc($results);
                echo "<script>alert('Profile Picture udated successfully!');window.location.href = '".$_SERVER['PHP_SELF']."';</script>";
            }else{
                echo "<script>alert('error updating database: ".mysqli_error($connection)."');</script>";
            }
        }else{
            echo "<script>alert('error uploading file.');</script>";
        }
    }else{
        echo "<script>alert('Invalid file typr. Only JPG, JPEG, PNG and GIF files are allowed.');window.location.href = '".$_SERVER['PHP_SELF']."'</script>";
    }
}else{
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Project(Profile).css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../general/Navigation.css?v=<?php echo time(); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="header">
    <?php
        if($userData):
    ?>

    <div class="navigation-white">
        <nav class="bar">
            <ul>
                <li><a href="../homepage/MainPage.php" class="navigation-white">Home</a></li>
                <li class="seperator">/</li>
                <li><a href="#" class="current navigation-white">Profile</a></li>
            </ul>
        </nav>   
    </div>

    <div class="setting">
    <input class="button" type="button" value="Setting ⚙" name="btnSetting" onclick="toggleDropdown()">
    <div id="dropdownList" class="dropdown-content">
        <a href="#" onclick="openPopup('resetPopup')">Reset Password</a>
        <hr>
        <a href="#" onclick="openPopup('privacyPopup')">Privacy</a>
        <hr>
        <a href="Project(Policy).php">Privacy Policy</a>
        <hr>
        <div id="confirm" class="confirmbar">
        <div class="bar-content">
            <span class="close">&times;</span>
            <h2>Log Out</h2>
            <p>Are you sure want to log out now?</p>
            <br>
            <button id="yes">Yes</button>
            <button id="no">No</button>
        </div>
        </div>
            <a href="#" id="logout">Log Out</a>
    </div>

    <div id="overlay" class="overlay"></div>

    <div class="popup2" id="resetPopup">
        <span class="close-btn" onclick="closePopup('resetPopup')">&times;</span>
        <h2>Reset Password</h2>
            <form action="" method="post">
                <table align="center">
                    <tr>
                        <td>Current Password: </td>
                    </tr>
                    <tr>
                    <td><input class="passwordfields1" type="password" id="oldPassword" name="oldPassword" required></td>
                    <td><button class="eye" id="togglePassword">👁</button></td>
                    </tr>
                    <tr>
                        <td>New Password: </td>
                    </tr>
                    <tr>
                    <td><input class="passwordfields2" type="password" id="newPassword" name="newPassword" required></td>
                    </tr>
                    <tr>
                        <td>Confirm Password:</td>
                    </tr>
                    <tr>
                    <td><input class="passwordfields3" type="password" id="confirmPassword" name="confirmPassword" required></td>
                    </tr>
                </table>
                <p align="center">
                    <input type="submit" value="Confirm" name="btnReset">
                </p>
            </form>
    </div>

    <div class="popup" id="privacyPopup">
        <span class="close-btn" onclick="closePopup('privacyPopup')">&times;</span>
            <h2>Privacy Setting</h2>
            <div class="section">
                <h4 class="title">Online Status</h4>
                <label class = "switch">
                    <input type="checkbox" id="onlineStatus">
                    <span class="slider round"></span>
                </label>
            </div>
    </div>
    </div>

    <div class="container">
    <div class="profile">
        <h2 class="target3">Profile</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <table align = "center">
                <tr>
                    <td><img class="image" src="showimage.php?userid=<?php echo htmlspecialchars($id); ?>" alt="My Profile">
                    <label for="online-status-toggle" class="circle"><span class="status-indicator"></span></label>
                    <input class="chooseFile" type="file" name="pic"> <br>
                    <input class="edit" type="submit" value="Edit Picture" name="btnEditImg">
                    </td>
                </tr>

                <tr>
                    <td>
                        <label for="txtFName" class="label1">First Name</label><input class="fields" type="text" name="txtFName" value="<?php echo htmlspecialchars($userData['firstname']);?>">
                        <label for="txtNumber" class="label1">Phone Number</label><input class="fields" type="text" name="txtNumber" value="<?php echo htmlspecialchars($userData['number']);?>">
                        <label for="txtEmail" class="label1">Email Address</label><input class="fields" type="text" name="txtEmail" value="<?php echo htmlspecialchars($userData['email']);?>">
                    </td>
                    <td>
                        <label for="txtLName" class="label2">Last Name</label><input class="fields2" type="text" name="txtLName" value="<?php echo htmlspecialchars($userData['lastname']);?>">
                        <label for="txtGender" class="label2">Gender</label><input class="fields2" type="text" name="txtGender" value="<?php echo htmlspecialchars($userData['gender']);?>">
                        <label for="txtCountry" class="label2">Country</label><input class="fields2" type="text" name="txtCountry" value="<?php echo htmlspecialchars($userData['country']);?>">
                    </td>
                </tr>
            </table>
            <p align="center">
                <input class="save" type="submit" value="Save" name="btnSave">
            </p>
        </form>
    </div>
    <?php else: ?>
        <p align="center">No user data found.</p>
    <?php endif; ?>

    <div class="goals">
        <div class="row1">
        <form action="#" method="post">
            <h2 class="target">Goals</h2>
            <table>
                <tr>
                    <td><input class="targetfield" type="text" name="txtGoals" id="goalsInput" placeholder="Enter your goal"></td>
                    <td><input class="saveGoals" type="submit" value="Save" name="btnGoals"></td>
                </tr>  
            </table>
            <h2 class="target">Your Goals</h2>
            <table id="goalsTable" class="table-fixed" border="1">
                <thead>
                <tr>
                    <th>Goals</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <?php
                        while($row = $result->fetch_assoc())
                        {
                    ?>
                        <td><input class="goalsfield" type="text" name="txtgoalname" value="<?php echo htmlspecialchars($row['goalsname']);?>"></td>
                </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </form>
        <p>
        <img src="../images/notepad.png" alt="NotePad" class="notepad">
        </p>    
        </div>
    </div>
    </div>

    <div class="achievements">
    <h2 class="target2">Achievements 🏆</h2>
        <div class="row">
            <?php
                if ($checkresult->num_rows > 0 ) {
                    while ($row = $checkresult->fetch_assoc()) {
                        $progress = $row['progress'];
                        $challengeID = $row['challengeid'];

                        if($progress == 7 && $challengeID != NULL && $challengeID != 0){
                            $readquery = "SELECT img, challengeName, difficulty FROM challengetable WHERE challengeid = ?";
                            $stmt2 = $connection->prepare($readquery);
                            $stmt2->bind_param('i', $challengeID);  // Assuming $userid contains the logged-in user's ID
                            $stmt2->execute();
                            $result = $stmt2->get_result();
                                
                            if($result->num_rows > 0){
                                while($row2 = $result->fetch_assoc()){
                                
            ?>
            <div class="content">
                <img class="pic"src="displayimage.php?challengeid=<?php echo htmlspecialchars($challengeID); ?>" alt="achievementspic" height="85" width="70" onerror="this.onerror=null;this.src='../images/archive.jpg';"> <br>
                <input class="text" type="text" name="txtchalname" value="<?php echo htmlspecialchars($row2['challengeName']);?>" readonly> <br>
                <input class="text2" type="text" name="txtlevel" value="<?php echo htmlspecialchars($row2['difficulty']);?>" readonly> 
            </div>
                <?php
                                    }
                                }else{
                                    echo "<p style='color: white; margin-left: 20px;'>No challenge details found for Challenge ID: " . htmlspecialchars($challengeID) . "</p>";
                                }
                                $stmt2->close();
                            }
                        }
                    }else {
                        echo "<p style='color: white; margin-left: 20px;'>No challenges found for the user.</p>";
                    }
                ?>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
        const confirmbar = document.getElementById("confirm");
        const btn = document.getElementById("logout");
        const closeBtn = document.getElementsByClassName("close")[0];
        const yesButton = document.getElementById("yes");
        const noButton = document.getElementById("no");

        // Show the modal when the button is clicked
        btn.addEventListener('click', function(event){
            event.preventDefault();
            confirmbar.style.display = "block";
        });

        closeBtn.addEventListener('click', function() {
            confirmbar.style.display = "none";
        });

        // Handle the confirm button click
        yesButton.addEventListener('click', function() {
            confirmbar.style.display = "none"; // Close the modal
            window.location.href = "Project(Logout).php"; // Redirect to logout
            alert('You have successfully logged out!'); // Display success message
        });

        noButton.addEventListener('click', function() {
            confirmbar.style.display = "none"; // Close the modal without logging out
        });
    });
    </script>

    <script>
        // Open Privacy Popup
        function openPopup(popupId) {
            var popup = document.getElementById(popupId);
            var overlay = document.getElementById("overlay");
            popup.style.display = "block";
            overlay.style.display = "block";
        }

        // Close Privacy Popup
        function closePopup(popupId) {
            var popup = document.getElementById(popupId);
            var overlay = document.getElementById("overlay");
            popup.style.display = "none";
            overlay.style.display = "none";
        }

        // Close popup if clicked outside the box
        window.onclick = function(event) {
            var overlay = document.getElementById('overlay');
            if (event.target == overlay) {
                var popup = document.querySelectorAll('.popup');
                popup.forEach(function(popup){
                    popup.style.display = "none";
                });
                overlay.style.display = "none";
            }
        }
    </script>
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
        const onlineStatusToggle = document.getElementById('onlineStatus'); // Correct toggle switch
        const statusIndicator = document.querySelector('.status-indicator'); // Circle

        // Load saved status from localStorage
        let isOnline = localStorage.getItem('onlineStatus') === 'true';
        onlineStatusToggle.checked = isOnline; // Set the switch state
        updateStatusIndicator(isOnline); // Update the circle immediately

        // Listen for toggle changes
        onlineStatusToggle.addEventListener('change', (event) => {
            isOnline = event.target.checked;
            localStorage.setItem('onlineStatus', isOnline); // Save the status
            updateStatusIndicator(isOnline); // Update the circle color
        });

        function updateStatusIndicator(isOnline) {
            if (isOnline) {
                statusIndicator.classList.add('online'); // Add green color
            } else {
                statusIndicator.classList.remove('online'); // Default grey
            }
        }
    });
    </script>

<script>
    const oldPasswordField = document.getElementById('oldPassword');
    const newPasswordField = document.getElementById('newPassword');
    const confirmPasswordField = document.getElementById('confirmPassword');
    const fields = [oldPasswordField, newPasswordField, confirmPasswordField];
    const toggleButton = document.getElementById('togglePassword');

    toggleButton.addEventListener('click', (event)=>{
        event.preventDefault();

        fields.forEach(field => {
            field.type = field.type === 'password' ? 'text' : 'password';
        });
    });
    
    </script>
    
    <script>
        function toggleDropdown(){
            const dropdown = document.getElementById('dropdownList');
            const isVisible = dropdown.style.display === 'block';
            dropdown.style.display = isVisible ? 'none' : 'block';
        }

        window.addEventListener('click', function(event) {
            const dropdown = document.getElementById('dropdownList');
            const settingButton = document.querySelector('.setting input[type="button"]'); // Selector for the setting button

            // Check if the click is outside the dropdown and the setting button
            if (!event.target.closest('.setting') && dropdown.style.display === 'block') {
                dropdown.style.display = 'none'; // Hide the dropdown if clicked outside
            }
        });
    </script>
    </div>
</body>
</html>

<?php
include '../general/Footer.php';
?>