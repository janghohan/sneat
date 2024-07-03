<?php 
include '../dbConnect.php';

$noticeId = $_POST['noticeId'];

$sql = "DELETE FROM notice_list WHERE notice_id = '$noticeId'";


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