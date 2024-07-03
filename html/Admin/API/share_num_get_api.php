<?php 
include '../dbConnect.php';

$shareHouseId = isset($_POST['shareHouse']) ? $_POST['shareHouse'] : 8;


$sql = "SELECT service_info FROM service_list WHERE service_id='$shareHouseId'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();


if ($conn->query($sql)) {
    echo $row['service_info'];
} else {
    echo 0;
}

$conn->close();


 ?>