<?php
include '../general/dbconn.php';

$readQuery = "SELECT img FROM challengetable WHERE challengeid = '$challengeID'";
$result = mysqli_query($connection, $readQuery);
if($result->num_row>0){
    $row = mysqli_fetch_assoc($result);
    $img = $row['img'];

    if ($img) {
        $info = getimagesizefromstring($img);
        header("Content-type: " . $info['mime']);
        echo $img;
    }else{
        header("Content-type: image/jpg");
        readfile('../images/archive.jpg');
    }
}else{
    header("Content-type: image/jpg");
    readfile('../images/archive.jpg');
}
?>