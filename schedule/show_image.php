<?php
include '../general/dbconn.php';

if (isset($_GET['userid'])) {
    $userid = $_GET['userid'];

    $query = "SELECT pic FROM usertable WHERE userid = '$userid'";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        header("Content-Type: image/jpeg");
        echo $row['pic'];
    } else {
        header("Content-Type: image/jpeg");
        readfile('default.jpg');
    }
} else {
    echo "No user ID provided!";
}
?>
