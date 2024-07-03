<?php 
include '../dbConnect.php';


$userId = isset($_POST['userId']) ? $_POST['userId'] : 'wkdgh5430';

$sql = "SELECT * FROM user_list WHERE user_id='$userId'";
$result = $conn->query($sql);


echo json_encode($row = $result->fetch_assoc());

 ?>