<?php
session_start();
include '../general/dbconn.php';

if(isset($_SESSION['userid'])) {
    $id = $_SESSION['userid'];
} else {
    die('User ID not found in URL.');
}

$imageQuery = "SELECT pic FROM usertable WHERE userid = '$id'";
$result = mysqli_query($connection, $imageQuery);
if($result->num_rows>0){
    $row = mysqli_fetch_assoc($result);
    $pic = $row['pic'];

    if ($pic) {
        $info = getimagesizefromstring($pic);
        header("Content-type: " . $info['mime']);
        echo $pic;
    }else{
        header("Content-type: image/jpg");
        readfile('../images/profile.jpg');
    }
}else{
    header("Content-type: image/jpg");
    readfile('../images/profile.jpg');
}


?>
