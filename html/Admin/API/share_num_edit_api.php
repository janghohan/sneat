<?php 
include '../dbConnect.php';

$shareHouseId = isset($_POST['shareHouse']) ? $_POST['shareHouse'] : '';
$shareInfo = isset($_POST['shareInfo']) ? $_POST['shareInfo'] : '';


$sql = "UPDATE service_list SET service_info='$shareInfo' WHERE service_id='$shareHouseId'";


if ($conn->query($sql)) {
    echo 1;
} else {
    echo 0;
}

$conn->close();


 ?>