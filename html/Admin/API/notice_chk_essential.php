<?php 
include '../dbConnect.php';

$noticeId = $_POST['noticeId'];
$essential = $_POST['essential'];


if($essential=="true"){
	$essential = '1';
}else{
	$essential = '0';
}
$sql = "UPDATE notice_list SET is_essential='$essential' WHERE notice_id='$noticeId'";

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