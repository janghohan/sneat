<?php 
include '../dbConnect.php';

$noticeId = $_POST['noticeId'];
$pinned = $_POST['pinned'];


if($pinned=="true"){
	$pinned = '1';
}else{
	$pinned = '0';
}
$sql = "UPDATE notice_list SET is_pinned='$pinned' WHERE notice_id='$noticeId'";

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