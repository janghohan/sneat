<?php 
include '../dbConnect.php';

$serviceId = isset($_POST['serviceId']) ? $_POST['serviceId'] : 1;


$sql = "SELECT * FROM service_list WHERE service_id='$serviceId'";
$result = $conn->query($sql);

$row = $result -> fetch_assoc();

$data = json_encode(
	array(
		'service_price' => $row['service_price'], 
		'service_min' => $row['service_min'],
		'service_max' => $row['service_max'],
		'service_addCost' => $row['service_addcost']
	)
);

echo $data;

 ?>