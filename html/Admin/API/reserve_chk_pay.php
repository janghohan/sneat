<?php 
include '../dbConnect.php';

$serviceId = isset($_POST['serviceId']) ? $_POST['serviceId'] : '';
$reserveId = isset($_POST['reserveId']) ? $_POST['reserveId'] : '';
$pay = isset($_POST['pay']) ? $_POST['pay'] : '';


if($pay=="true"){
	$pay = '1';
}else{
	$pay = '0';
}

$today = date("Y-m-d H:i:s");

if($serviceId<=3){
	$sql = "UPDATE booked_list SET payment_ok='$pay',booked_ok='$pay',payment_time='$today' WHERE booked_id='$reserveId'";
}else{
	$sql = "UPDATE hourbooked_list SET payment_ok='$pay',booked_ok='$pay',payment_time='$today' WHERE booked_id='$reserveId'";
}


if ($conn->query($sql) === TRUE) {
    $data = json_encode(array(
	    'dataCode' => 200,
	));
} else {
	$data = json_encode(array(
	    'dataCode' => 101,
	));
}

echo $data;

$conn->close();
?>