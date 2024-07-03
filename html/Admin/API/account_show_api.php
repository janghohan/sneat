<?php 
include '../dbConnect.php';


$accountId = isset($_POST['accountId']) ? $_POST['accountId'] : 'wkdgh5430';

$sql = "SELECT * FROM admin_account WHERE account_id='$accountId'";
$result = $conn->query($sql);


echo json_encode($row = $result->fetch_assoc());

 ?>