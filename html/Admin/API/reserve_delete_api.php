<?php 
include '../dbConnect.php';

$serviceId = isset($_POST['serviceId']) ? $_POST['serviceId'] : '';
$reserveId = isset($_POST['reserveId']) ? $_POST['reserveId'] : '';

if($serviceId<=3){
	$sql = "DELETE FROM booked_list WHERE booked_id = '$reserveId'";
}else{
	$sql = "DELETE FROM hourbooked_list WHERE booked_id = '$reserveId'";
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