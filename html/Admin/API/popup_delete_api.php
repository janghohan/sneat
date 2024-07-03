<?php 
include '../dbConnect.php';

$popupId = $_POST['popupId'];

$sql = "DELETE FROM popup_list WHERE popup_id = '$popupId'";


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